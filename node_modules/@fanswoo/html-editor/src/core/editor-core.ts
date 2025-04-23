import { watch, computed, provide, reactive, ref } from 'vue';
import { Editor, EditorContent } from '@tiptap/vue-3';
import EditorCore from './editor-core.vue';
import EditorMenu from '@fanswoo/html-editor/layouts/editor-menu.vue';
import StarterKit from '@tiptap/starter-kit';
import AdditionalKit from './additional-kit';

const createEditor = (options) => {
  const { content, props } = options;
  
  const styleObject = {
    width: props.width ? `${props.width}px` : 'auto',
    height: props.height ? `${props.height}px` : 'auto',
    'min-height': props.minHeight ? `${props.minHeight}px` : 'auto',
    'max-height': props.maxHeight ? `${props.maxHeight}px` : 'auto',
  };
  
  const style = Object.entries(styleObject)
    .map(([key, value]) => `${key}: ${value}`)
    .join(';');
  
  const editor = reactive(
    new Editor({
      content: content.value,
      extensions: [
        StarterKit,
        AdditionalKit.configure({
          placeholder: {
            placeholder: props.placeholder,
          },
        }),
      ],
      editorProps: {
        attributes: {
          style,
        },
      },
      injectCSS: false,
    }),
  );
  
  provide(
    'editor',
    computed(() => editor),
  );
  
  const editorHtmlContent = ref(editor.getHTML());
  
  editor.on('update', ({ editor }) => {
    content.value = editor.getHTML();
  });
  
  editor.on('focus', ({ editor, event }) => {
  });
  
  watch(() => content.value, (value) => {
    editor.commands.setContent(
      value,
      false,
      {
        preserveWhitespace: "full"
      });
    let { from, to } = editor.state.selection;
    editor.commands.setTextSelection({ from, to });
  });
  
  return { editor, editorHtmlContent };
};

export { createEditor, EditorCore as Editor, EditorContent, EditorMenu };
