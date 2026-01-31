import {Extension} from '@tiptap/core'
import {Plugin, PluginKey} from '@tiptap/pm/state'
import {html as beautifyHtml} from 'js-beautify'

const editorStates = new WeakMap()

// Used to force editorUpdatedAt updates (so Alpine re-evaluates isActive bindings)
const SOURCE_CODE_PLUGIN_KEY = new PluginKey('source-code')

function getEditorWrapper(editor) {
    return editor?.options?.element?.closest?.('.fi-fo-rich-editor')
}

function getToolbar(editorWrapper) {
    return editorWrapper?.querySelector?.('.fi-fo-rich-editor-toolbar')
}

function getToolbarButtons(toolbar) {
    return toolbar ? Array.from(toolbar.querySelectorAll('button.fi-fo-rich-editor-tool')) : []
}

function getSourceButton(toolbar) {
    return toolbar?.querySelector?.('button[data-tiptap-menu-item-name="source-code"]')
}

function setButtonDisabled(button, disabled, previousTabIndex = null) {
    if (!button) return

    button.disabled = disabled

    if (disabled) {
        button.setAttribute('aria-disabled', 'true')
        button.setAttribute('tabindex', '-1')
        return
    }

    button.removeAttribute('aria-disabled')

    // Restore tabindex strictly to what it was before, otherwise remove.
    if (previousTabIndex === null) {
        button.removeAttribute('tabindex')
    } else {
        button.setAttribute('tabindex', previousTabIndex)
    }
}

function disableOtherToolbarButtons(editor, state) {
    const editorWrapper = getEditorWrapper(editor)
    const toolbar = getToolbar(editorWrapper)
    const sourceButton = getSourceButton(toolbar)

    if (!toolbar) return

    const buttons = getToolbarButtons(toolbar)

    // snapshot current state so we can restore precisely later
    state.toolbarButtonsSnapshot = new Map()

    for (const button of buttons) {
        if (button === sourceButton) continue

        state.toolbarButtonsSnapshot.set(button, {
            disabled: button.disabled,
            tabIndex: button.getAttribute('tabindex'),
        })

        setButtonDisabled(button, true)
    }
}

function restoreOtherToolbarButtons(state) {
    if (!state.toolbarButtonsSnapshot) return

    for (const [button, snapshot] of state.toolbarButtonsSnapshot.entries()) {
        setButtonDisabled(button, snapshot.disabled, snapshot.tabIndex)
    }

    state.toolbarButtonsSnapshot = null
}

window.formatHtml = function (html) {
    try {
        return beautifyHtml(html, {
            indent_size: 2,
            indent_char: ' ',
            max_preserve_newlines: 1,
            preserve_newlines: true,
            wrap_line_length: 0,
            wrap_attributes: 'auto',
            unformatted: ['code', 'pre', 'em', 'strong', 'span'],
            content_unformatted: ['pre', 'textarea'],
            indent_inner_html: true,
            indent_body_inner_html: true,
            indent_head_inner_html: true,
            end_with_newline: false,
            extra_liners: [],
        })
    } catch (error) {
        console.warn('Failed to format HTML:', error)
        return html
    }
}

export default Extension.create({
    name: 'source-code',

    addStorage() {
        return {
            isSourceMode: false,
        }
    },

    addProseMirrorPlugins() {
        return [
            new Plugin({
                key: SOURCE_CODE_PLUGIN_KEY,
                state: {
                    init: () => ({ isSourceMode: false }),
                    apply: (tr, value) => {
                        const meta = tr.getMeta(SOURCE_CODE_PLUGIN_KEY)
                        if (meta && typeof meta.isSourceMode === 'boolean') {
                            return { isSourceMode: meta.isSourceMode }
                        }
                        return value
                    },
                },
            }),
        ]
    },

    // TipTap's built-in isActive() checks marks/nodes; Filament's toolbar relies on it.
    // We expose source mode as an "active" state by providing a custom isActive hook.
    addCommands() {
        return {
            toggleSourceCode: (forceState = null) => ({ editor }) => {
                const editorWrapper = getEditorWrapper(editor)
                if (!editorWrapper) return false

                const state = editorStates.get(editor)
                if (!state) return false

                if (state.isSourceMode === forceState) {
                    return true
                }

                // Toggle state
                state.isSourceMode = forceState !== null ? forceState : !state.isSourceMode

                // Keep extension storage in sync
                editor.storage[this.name].isSourceMode = state.isSourceMode

                // Push plugin meta so TipTap/Filament re-renders (editorUpdatedAt) and the active binding can update
                editor.view.dispatch(editor.state.tr.setMeta(SOURCE_CODE_PLUGIN_KEY, { isSourceMode: state.isSourceMode }))

                if (state.isSourceMode) {
                    // Switching to source mode
                    const htmlContent = state.originalGetHTML()
                    const formattedHtml = formatHtml(htmlContent)
                    state.sourceContent = formattedHtml

                    const textarea = document.createElement('textarea')
                    textarea.value = formattedHtml
                    textarea.className = 'source-view-textarea'
                    textarea.style.cssText = 'width: 100%; height: 100%; min-height: 310px; font-family: monospace; font-size: 13px; padding: 10px; border: none; outline: none; resize: vertical; background: transparent; color: inherit;'

                    textarea.addEventListener('input', (e) => {
                        state.sourceContent = e.target.value

                        // Keep the editor model up-to-date so external consumers reading editor.getHTML() see latest value.
                        const currentContent = state.originalGetHTML()
                        if (currentContent !== state.sourceContent) {
                            editor.commands.setContent(state.sourceContent, false)
                        }
                    })

                    const proseMirrorElement = editorWrapper.querySelector('.tiptap.ProseMirror')
                    if (proseMirrorElement) {
                        proseMirrorElement.style.display = 'none'
                        proseMirrorElement.insertAdjacentElement('afterend', textarea)
                        state.textareaElement = textarea
                    }

                    editorWrapper.classList.add('source-code')

                    // Disable other toolbar buttons while in source mode
                    disableOtherToolbarButtons(editor, state)
                } else {
                    // Switching FROM source mode back to normal
                    const htmlContent = state.sourceContent

                    if (state.textareaElement) {
                        state.textareaElement.remove()
                        state.textareaElement = null
                    }

                    const proseMirrorElement = editorWrapper.querySelector('.tiptap.ProseMirror')
                    if (proseMirrorElement) {
                        proseMirrorElement.style.display = ''
                    }

                    editorWrapper.classList.remove('source-code')

                    // Restore toolbar buttons
                    restoreOtherToolbarButtons(state)

                    editor.commands.setContent(htmlContent)
                    state.sourceContent = null
                }

                return true
            },

            // Backwards compatibility: some code paths used toggleSource().
            toggleSource: () => ({ editor }) => editor.commands.toggleSourceCode(),
        }
    },

    onCreate() {
        const state = {
            isSourceMode: false,
            sourceContent: null,
            textareaElement: null,
            toolbarButtonsSnapshot: null,
        }

        editorStates.set(this.editor, state)

        const originalGetHTML = this.editor.getHTML.bind(this.editor)

        this.editor.getHTML = () => {
            const currentState = editorStates.get(this.editor)
            if (currentState && currentState.isSourceMode) {
                if (currentState.textareaElement) {
                    currentState.sourceContent = currentState.textareaElement.value
                }
                return currentState.sourceContent || ''
            }
            return originalGetHTML()
        }

        state.originalGetHTML = originalGetHTML

        // Store handler so we can remove it in onDestroy
        state.exitSourceModeHandler = (event) => {
            const statePath = event.detail?.statePath
            if (!statePath) return

            const editorWrapper = getEditorWrapper(this.editor)
            const currentState = editorStates.get(this.editor)

            if (currentState && currentState.isSourceMode) {
                this.editor.commands.toggleSourceCode(false)

                // Safety: ensure wrapper class is consistent
                if (!editorWrapper?.classList?.contains('source-code') && currentState.isSourceMode) {
                    editorWrapper?.classList?.add('source-code')
                }
            }
        }

        window.addEventListener('exit-source-mode', state.exitSourceModeHandler)

        // Make editor.isActive('source-code') reflect source mode for Filament's Alpine binding.
        const originalIsActive = this.editor.isActive.bind(this.editor)
        this.editor.isActive = (name, attributes = {}) => {
            if (name === this.name) {
                return !!this.editor.storage[this.name]?.isSourceMode
            }
            return originalIsActive(name, attributes)
        }

        state.originalIsActive = originalIsActive
    },

    addKeyboardShortcuts() {
        return {
            Escape: () => {
                const state = editorStates.get(this.editor)
                if (state && state.isSourceMode) {
                    return this.editor.commands.toggleSourceCode(false)
                }
            },
            'Mod-Shift-l': () => this.editor.commands.toggleSourceCode(),
        }
    },

    onDestroy() {
        const state = editorStates.get(this.editor)
        if (state?.exitSourceModeHandler) {
            window.removeEventListener('exit-source-mode', state.exitSourceModeHandler)
        }

        // Restore original isActive if we overwrote it
        if (state?.originalIsActive) {
            this.editor.isActive = state.originalIsActive
        }

        editorStates.delete(this.editor)
    },
})
