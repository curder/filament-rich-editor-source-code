import { Node, mergeAttributes } from "@tiptap/core";

export default Node.create({
    name: "div",
    priority: 1000,
    group: "block",
    content: "block+",
    defining: true,

    addOptions() {
        return { HTMLAttributes: {} };
    },

    addAttributes() {
        return {
            id: {
                default: null,
                parseHTML: element => element.getAttribute('id'),
                renderHTML: attributes => {
                    return attributes.id ? { id: attributes.id } : {};
                },
            },
            class: {
                default: null,
                parseHTML: element => element.getAttribute('class'),
                renderHTML: attributes => {
                    return attributes.class ? { class: attributes.class } : {};
                },
            },
        };
    },

    parseHTML() {
        return [{
            tag: 'div',
            getAttrs: element => {
                const id = element.getAttribute('id') || '';
                const className = element.getAttribute('class') || '';
                return {id, class: className};
            },
        }];
    },

    renderHTML({ HTMLAttributes }) {
        return ['div', mergeAttributes(this.options.HTMLAttributes, HTMLAttributes), 0];
    },
});