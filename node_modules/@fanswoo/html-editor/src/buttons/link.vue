<template>
  <div class="link-button-group">
    <button
      ref="linkButton"
      type="button"
      :class="{ 'is-active': editor.isActive('link') }"
      :disabled="!editor.isActive('link') && getSelectedText() === ''"
      @click="addLink"
    >
      <FontAwesomeIcon icon="link" />
    </button>
    <BubbleMenu
      :shouldShow="shouldShow"
      :class="{ 'link-panel': true }"
      :editor="editor"
      pluginKey="link"
    >
      <input
        ref="inputLink"
        type="text"
        placeholder="http://"
        :value="editor.getAttributes('link').href"
      />
      <button
        type="button"
        ref="checkButton"
        @click="changeLink"
      >
        <FontAwesomeIcon icon="check" />
      </button>
      <button
        ref="openNewLinkButton"
        type="button"
        @click="openNewLink"
      >
        <FontAwesomeIcon icon="external-link-alt" />
      </button>
      <button
        ref="unlinkButton"
        type="button"
        @click="editor.chain().focus().unsetLink().run()"
      >
        <FontAwesomeIcon icon="unlink" />
      </button>
    </BubbleMenu>
  </div>
</template>

<script lang="ts" setup>
import { inject, ref, nextTick, onMounted } from 'vue';
import { BubbleMenu } from '@tiptap/vue-3';
import tippy from 'tippy.js';

const editor: any = inject('editor');

const linkButton = ref(null);
const unlinkButton = ref(null);
const checkButton = ref(null);
const openNewLinkButton = ref(null);

const inputLink = ref(null);

const getSelectedText = (): string => {
  // console.log(editor.value);
  const { state } = editor.value;
  const { from, to } = state.selection;
  return state.doc.textBetween(from, to, ' ');
};

const addLink = async () => {
  await nextTick();
  const url = editor.value.getAttributes('link').href;

  if (url && !editor.value.isActive('link')) {
    editor.value.chain().focus().setLink({ href: url }).run();
    return;
  }

  if (url && editor.value.isActive('link')) {
    editor.value.chain().focus().extendMarkRange('link', { href: url }).run();
    return;
  }

  editor.value
    .chain()
    .focus()
    .extendMarkRange('link')
    .setLink({ href: '' })
    .run();
};

const shouldShow = (arg) => {
  const isActive = arg.editor.isActive('link');
  return isActive;
};

const openNewLink = () => {
  const url = editor.value.getAttributes('link').href;
  if (url) {
    window.open(url, '_blank');
  }
};

const changeLink = async () => {
  let url = (inputLink.value as HTMLInputElement).value;

  if (!url.includes('http://', 0) && !url.includes('https://', 0)) {
    url = `http://${url}`;
  }

  if (url === '') {
    editor.value.chain().focus().extendMarkRange('link').unsetLink()!.run();
    return;
  }

  editor.value
    .chain()
    .focus()
    .extendMarkRange('link')
    .setLink({ href: url })
    .run();
  // editor.value.commands.blur();
};

onMounted(() => {
  tippy(linkButton.value, {
    content: '超連結',
    theme: 'tooltip',
  });
  tippy(unlinkButton.value, {
    content: '取消連結',
    theme: 'tooltip',
  });
  tippy(checkButton.value, {
    content: '確認連結',
    theme: 'tooltip',
  });
  tippy(openNewLinkButton.value, {
    content: '開啟連結',
    theme: 'tooltip',
  });
});
</script>

<script lang="ts">
export default {
  name: 'LinkButton',
};
</script>

<style lang="scss" scoped>
$color-blue: #027de5;

.link-panel {
  background: #f1f1f1;
  padding: 2px 0 2px 2px;
  border: 1px solid #ddd;
  box-shadow: 2px 2px 2px rgba(50, 50, 50, 0.1);
  input {
    height: 25px;
    border: 0;
    margin-right: 5px;
    width: 200px;
    &:focus {
      outline: 0;
    }
  }
  button {
    background: #f1f1f1;
    border-radius: 3px;
    width: 25px;
    height: 25px;
    border: 0;
    cursor: pointer;
    margin-right: 5px;
    transition: background 0.2s;
    &:hover {
      background: #ddd;
    }
  }
}
</style>
