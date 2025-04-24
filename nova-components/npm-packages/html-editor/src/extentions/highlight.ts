import '@tiptap/extension-text-style';

import { Extension } from '@tiptap/core';

export type HighlightOptions = {
  types: string[];
};

declare module '@tiptap/core' {
  interface Commands<ReturnType> {
    backgroundColor: {
      /**
       * Set the text background color
       */
      setHighlight: (backgroundColor: string) => ReturnType;
      /**
       * Unset the text background color
       */
      unsetHightlight: () => ReturnType;
    };
  }
}

export const Highlight = Extension.create<HighlightOptions>({
  name: 'highlight',

  addOptions() {
    return {
      types: ['textStyle'],
    };
  },

  addGlobalAttributes() {
    return [
      {
        types: this.options.types,
        attributes: {
          backgroundColor: {
            default: null,
            parseHTML: (element) =>
              element.style.backgroundColor?.replace(/['"]+/g, ''),
            renderHTML: (attributes) => {
              if (!attributes.backgroundColor) {
                return {};
              }

              return {
                style: `background-color: ${attributes.backgroundColor}`,
              };
            },
          },
        },
      },
    ];
  },

  addCommands() {
    return {
      setHighlight:
        (backgroundColor) =>
        ({ chain }) => {
          return chain().setMark('textStyle', { backgroundColor }).run();
        },
      unsetHighlight:
        () =>
        ({ chain }) => {
          return chain()
            .setMark('textStyle', { backgroundColor: null })
            .removeEmptyTextStyle()
            .run();
        },
    };
  },
});
