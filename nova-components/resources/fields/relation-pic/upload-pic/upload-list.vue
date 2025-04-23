<template>
  <div class="pic-upload-list">
    <Draggable v-model="pics" :handle="'.move'" :filter="'.pic'">
      <template v-if="pics?.length > 0">
        <template v-for="(pic, index) in pics" :key="index">
          <div class="upload-item">
            <div class="pic">
              <img
                ref="viewer"
                v-viewer="{
                  movable: false,
                  navbar: false,
                  toolbar: false,
                  title: false,
                  url: 'src-source',
                  zIndex: 10000,
                }"
                :src-source="pic.url['w0h0']"
                :src="pic.url['w50h50']"
              />
            </div>
            <div class="tool-list">
              <span ref="move" class="move" title="移動">
                <font-awesome-icon icon="hand-paper" />
              </span>
              <span ref="scale" class="scale" @click="showPic(index)" title="放大">
                <font-awesome-icon icon="search-plus" />
              </span>
              <span ref="copyLink" @click="copyLinkToClipboard(index)" title="複製">
                <font-awesome-icon icon="clipboard" />
                <input
                  ref="copyLinkInput"
                  type="hidden"
                  class="copy-link"
                  :value="pic.url['w0h0']"
                />
              </span>
              <span ref="deleteIcon" @click="onPicDelete(pic.id)" title="刪除圖片">
                <font-awesome-icon icon="trash" />
              </span>
            </div>
            <input type="hidden" :name="inputName + '[]'" :value="pic.id" />
          </div>
        </template>
      </template>
    </Draggable>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import { VueDraggableNext as Draggable } from 'vue-draggable-next';

const props = defineProps({
  inputName: {
    type: String,
    default: '',
  },
});

const pics = defineModel();
const message = ref('');
const copyLinkInput = ref([]);
const viewer = ref([]);

const onPicDelete = (id) => {
  if (!window.confirm('確定要刪除圖片嗎？')) {
    return false;
  }

  pics.value.forEach((pic, index) => {
    if (pic.id === id) {
      pics.value.splice(index, 1);
      return true;
    }
  });

  return false;
};

const copyLinkToClipboard = (index) => {
  const copyLink = copyLinkInput.value[index];
  copyLink.setAttribute('type', 'text');
  copyLink.select();

  try {
    document.execCommand('copy');
    alert('複製路徑成功');
  } catch (err) {
    alert('複製路徑失敗');
  }

  copyLink.setAttribute('type', 'hidden');
  window.getSelection().removeAllRanges();
};

const showPic = (index) => {
  viewer.value[index].$viewer.show();
};
</script>


<style lang="scss" scoped>
@import '@fanswoo/core/style/modules/boot.scss';
$color-blue: #027de5;

.pic-upload-list {
  overflow: hidden;
  padding-top: 5px;
  .upload-item {
    float: left;
    margin: 0 5px 5px 0;
    overflow: hidden;
    background: #ddd;
    border-radius: 5px;
    position: relative;
    width: 56px;
    height: 56px;
    border: 3px solid #ccc;
    .pic {
      position: absolute;
      display: block;
      width: 50px;
      height: 50px;
      margin-bottom: 5px;
      overflow: hidden;
      cursor: zoom-in;
      img {
        width: 50px;
        height: 50px;
      }
    }
    .tool-list {
      position: absolute;
      width: 50px;
      opacity: 0;
      background: rgba(0, 0, 0, 0.6);
      transition: opacity 0.3s;
      &:hover {
        opacity: 1;
      }
      @include media-down(sm) {
        background: rgba(0, 0, 0, 0.4);
        opacity: 1;
      }
      span {
        float: left;
        color: #fff;
        cursor: pointer;
        font-size: 15px;
        display: block;
        width: 25px;
        height: 25px;
        line-height: 25px;
        text-align: center;
        &.move {
          cursor: move;
        }
        &.scale {
          cursor: zoom-in;
        }
        svg {
          width: 15px;
          height: 15px;
        }
      }
    }
  }
}
</style>
