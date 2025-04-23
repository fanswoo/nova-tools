<template>
  <div class="table-toggle-button">
    <button
      ref="insertTableButton"
      type="button"
      @click="toggleInsertPanel"
      :disabled="editor.isActive('table')"
    >
      <FontAwesomeIcon icon="table" />
    </button>
    <div
      :class="{
        'table-panel': true,
        'is-open': isOpenInsertPanel,
      }"
    >
      <div class="table-cell-shown">
        <button
          v-for="cell in cells"
          type="button"
          :class="{
            'table-cell-button': true,
            'is-active': cell.isActive,
          }"
          @click="insertTable(cell.row, cell.column)"
          @mouseenter="onCellHover(cell.row, cell.column)"
        ></button>
      </div>
      <div class="table-fields-shown">{{ tableFieldsShown }}</div>
    </div>
    <BubbleMenu
      :shouldShow="shouldShow"
      :class="{ 'table-bubble-panel': true }"
      :editor="editor"
      pluginKey="table"
    >
      <button
        ref="columnTableButton"
        type="button"
        @click="toggleColumnPanel"
      >
        <FontAwesomeIcon icon="grip-lines-vertical" />
      </button>
      <div
        :class="{
          'child-panel': true,
          'is-open': isOpenColumnPanel,
        }"
      >
        <button
          type="button"
          @click="editor.chain().focus().addColumnBefore().run()"
        >
          <FontAwesomeIcon icon="plus" />
          向左插入縱欄
        </button>
        <button
          type="button"
          @click="editor.chain().focus().addColumnAfter().run()"
        >
          <FontAwesomeIcon icon="plus" />
          向右插入縱欄
        </button>
        <button
          type="button"
          @click="editor.chain().focus().deleteColumn().run()"
        >
          <FontAwesomeIcon icon="trash" />
          刪除此縱欄
        </button>
      </div>
      <button
        ref="rowTableButton"
        type="button"
        @click="toggleRowPanel"
      >
        <FontAwesomeIcon icon="grip-lines" />
      </button>
      <div
        :class="{
          'child-panel': true,
          'is-open': isOpenRowPanel,
        }"
      >
        <button
          type="button"
          @click="editor.chain().focus().addRowBefore().run()"
        >
          <FontAwesomeIcon icon="plus" />
          向上插入橫列
        </button>
        <button
          type="button"
          @click="editor.chain().focus().addRowAfter().run()"
        >
          <FontAwesomeIcon icon="plus" />
          向下插入橫列
        </button>
        <button
          type="button"
          @click="editor.chain().focus().deleteRow().run()"
        >
          <FontAwesomeIcon icon="trash" />
          刪除此橫列
        </button>
      </div>

      <button
        type="button"
        ref="headTableButton" @click="toggleHeadPanel"
      >
        <FontAwesomeIcon icon="columns" />
      </button>
      <div
        :class="{
          'child-panel': true,
          'is-open': isOpenHeadPanel,
        }"
      >
        <button
          type="button"
          @click="editor.chain().focus().toggleHeaderColumn().run()"
        >
          <FontAwesomeIcon icon="grip-vertical" />
          啟閉標題欄
        </button>
        <button
          type="button"
          @click="editor.chain().focus().toggleHeaderRow().run()"
        >
          <FontAwesomeIcon icon="grip-horizontal" />
          啟閉標題列
        </button>
      </div>

      <button
        ref="mergeTableButton"
        type="button"
        @click="editor.chain().focus().mergeCells().run()"
      >
        <FontAwesomeIcon icon="border-none" />
      </button>
      <button
        ref="splitTableButton"
        type="button"
        @click="editor.chain().focus().splitCell().run()"
      >
        <FontAwesomeIcon icon="border-all" />
      </button>

      <button
        ref="deleteTableButton"
        type="button"
        @click="editor.chain().focus().deleteTable().run()"
      >
        <FontAwesomeIcon icon="trash" />
      </button>
    </BubbleMenu>
  </div>
</template>

<script lang="ts" setup>
import { inject, onMounted, ref } from 'vue';
import tippy from 'tippy.js';
import { BubbleMenu } from '@tiptap/vue-3';

interface Cell {
  row: number;
  column: number;
  isActive: boolean;
}

const editor: any = inject('editor');
const isOpenInsertPanel = ref(false);
const isOpenColumnPanel = ref(false);
const isOpenRowPanel = ref(false);
const isOpenHeadPanel = ref(false);
const insertTableButton = ref(null);
const columnTableButton = ref(null);
const rowTableButton = ref(null);
const headTableButton = ref(null);
const mergeTableButton = ref(null);
const splitTableButton = ref(null);
const deleteTableButton = ref(null);
const tableFieldsShown = ref('0 × 0');

const originCells = [];

for (let i = 0; i < 100; i += 1) {
  originCells.push({
    row: Math.floor(i / 10),
    column: i % 10,
    isActive: false,
  });
}

const cells = ref<Cell[]>(originCells);

onMounted(() => {
  tippy(insertTableButton.value, {
    content: '插入表格',
    theme: 'tooltip',
  });
  tippy(columnTableButton.value, {
    content: '調整縱欄',
    theme: 'tooltip',
  });
  tippy(rowTableButton.value, {
    content: '調整橫列',
    theme: 'tooltip',
  });
  tippy(headTableButton.value, {
    content: '表格標題',
    theme: 'tooltip',
  });
  tippy(mergeTableButton.value, {
    content: '合併儲存格',
    theme: 'tooltip',
  });
  tippy(splitTableButton.value, {
    content: '分割儲存格',
    theme: 'tooltip',
  });
  tippy(deleteTableButton.value, {
    content: '刪除表格',
    theme: 'tooltip',
  });
});

const closePanel = () => {
  isOpenInsertPanel.value = false;
};

const toggleInsertPanel = () => {
  isOpenInsertPanel.value = !isOpenInsertPanel.value;
};

const toggleColumnPanel = () => {
  isOpenColumnPanel.value = !isOpenColumnPanel.value;
  isOpenRowPanel.value = false;
  isOpenHeadPanel.value = false;
};

const toggleRowPanel = () => {
  isOpenRowPanel.value = !isOpenRowPanel.value;
  isOpenColumnPanel.value = false;
  isOpenHeadPanel.value = false;
};

const toggleHeadPanel = () => {
  isOpenHeadPanel.value = !isOpenHeadPanel.value;
  isOpenColumnPanel.value = false;
  isOpenRowPanel.value = false;
};

const shouldShow = (arg) => {
  const isActive = arg.editor.isActive('table') && !arg.editor.isActive('link');
  isOpenColumnPanel.value = false;
  isOpenRowPanel.value = false;
  isOpenHeadPanel.value = false;
  return isActive;
};

const insertTable = (row, column) => {
  editor.value
    .chain()
    .focus()
    .insertTable({ rows: row + 1, cols: column + 1, withHeaderRow: true })
    .run();
  isOpenInsertPanel.value = false;
};

const onCellHover = (row, column) => {
  cells.value.forEach((cell, index) => {
    cells.value[index].isActive = false;
  });

  cells.value.forEach((cell, index) => {
    if (cell.row <= row && cell.column <= column) {
      cells.value[index].isActive = true;
    }
  });
  tableFieldsShown.value = `${column + 1} × ${row + 1}`;
};

document.addEventListener('click', (event: any) => {
  if (
    isOpenInsertPanel.value &&
    !insertTableButton.value.contains(event.target)
  ) {
    closePanel();
  }
});
</script>

<script lang="ts">
export default {
  name: 'TableButton',
};
</script>

<style lang="scss" scoped>
$color-blue: #027de5;

.table-bubble-panel {
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
    line-height: 25px;
    border: 0;
    cursor: pointer;
    margin-right: 5px;
    transition: background 0.2s;
    &:hover {
      background: #ddd;
    }
  }
  .child-panel {
    position: absolute;
    display: none;
    width: 120px;
    box-shadow: 2px 2px 2px rgba(50, 50, 50, 0.1);
    background: #fff;
    &.is-open {
      display: block;
    }
    button {
      width: 100%;
      background: #fff;
      transition: 0.2s;
      text-align: left;
      &:hover {
        background: #ddd;
      }
      svg {
        width: 18px;
      }
    }
  }
}

.tableWrapper {
  padding: 1rem 0;
  overflow-x: auto;
}

.resize-cursor {
  cursor: ew-resize;
  cursor: col-resize;
}
</style>
