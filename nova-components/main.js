import '@fanswoo/core/bootstrap/bootstrap';
import './resources/core/style.scss';
import IndexIdField from './resources/fields/id/index-field.vue';
import IndexUrlField from './resources/fields/url/index-field.vue';
import DetailUrlField from './resources/fields/url/detail-field.vue';
import IndexDisplayField from './resources/fields/display/index-field.vue';
import DetailDisplayField from './resources/fields/display/detail-field.vue';
import FormDisplayField from './resources/fields/display/form-field.vue';
import IndexPicField from './resources/fields/pic/index-field.vue';
import DetailPicField from './resources/fields/pic/detail-field.vue';
import IndexRelationPicField from './resources/fields/relation-pic/index-field.vue';
import DetailRelationPicField from './resources/fields/relation-pic/detail-field.vue';
import FormRelationPicField from './resources/fields/relation-pic/form-field.vue';
import DetailRelationFileField from './resources/fields/relation-file/detail-field.vue';
import FormRelationFileField from './resources/fields/relation-file/form-field.vue';
import FormHtmlEditorField from './resources/fields/html-editor/form-field.vue';
import IndexDateTimeField from './resources/fields/date-time/index-field.vue';
import DetailDateTimeField from './resources/fields/date-time/detail-field.vue';
import FormDateTimeField from './resources/fields/date-time/form-field.vue';
import FormGroupBooleanField from './resources/fields/boolean-group/form-field.vue';
import FormMorphTagField from './resources/fields/morph-tag/form-field.vue';
import DetailMorphTagField from '@/fields/Detail/TagField.vue';
import IndexMorphTagField from '@/fields/Index/TagField.vue';
import FormHasManyButton from './resources/fields/has-many-button/form-field.vue';
import DetailHasManyButton from '@/fields/Detail/TagField.vue';
import IndexHasManyButton from '@/fields/Index/TagField.vue';
import FormCustomField from './resources/layouts/fields/custom-field/form-field.vue';
import GlobalComponents from "@fanswoo/core/bootstrap/global-components";
import 'viewerjs/dist/viewer.css';
import VueViewer from 'v-viewer';
import { setupCalendar } from 'v-calendar';
import { createBootstrap } from "bootstrap-vue-next";

Nova.booting((app, store) => {
  app.use(createBootstrap({components: true, directives: true}));
  app.use(GlobalComponents);
  app.use(VueViewer);
  app.use(setupCalendar);
});

Nova.booting((app, store) => {
  app.component('index-id-field', IndexIdField);
});

Nova.booting((app, store) => {
  app.component('index-url-field', IndexUrlField);
  app.component('detail-url-field', DetailUrlField);
});

Nova.booting((app, store) => {
  app.component('index-display-field', IndexDisplayField);
  app.component('detail-display-field', DetailDisplayField);
  app.component('form-display-field', FormDisplayField);
});

Nova.booting((app, store) => {
  app.component('index-pic-field', IndexPicField);
  app.component('detail-pic-field', DetailPicField);
});

Nova.booting((app, store) => {
  app.component('index-relation-pic-field', IndexRelationPicField);
  app.component('detail-relation-pic-field', DetailRelationPicField);
  app.component('form-relation-pic-field', FormRelationPicField);
});

Nova.booting((app, store) => {
  app.component('detail-relation-file-field', DetailRelationFileField);
  app.component('form-relation-file-field', FormRelationFileField);
});

Nova.booting((app, store) => {
  app.component('form-html-editor-field', FormHtmlEditorField);
});

Nova.booting((app, store) => {
  app.component('index-date-time-field', IndexDateTimeField);
  app.component('detail-date-time-field', DetailDateTimeField);
  app.component('form-date-time-field', FormDateTimeField);
});

Nova.booting((app, store) => {
  app.component('form-boolean-group-field', FormGroupBooleanField);
});

Nova.booting((app, store) => {
  app.component('form-morph-tag-field', FormMorphTagField);
  app.component('detail-morph-tag-field', DetailMorphTagField);
  app.component('index-morph-tag-field', IndexMorphTagField);
  app.component('form-has-many-button', FormHasManyButton);
  app.component('detail-has-many-button', DetailHasManyButton);
  app.component('index-has-many-button', IndexHasManyButton);
});

Nova.booting((app, store) => {
  app.component('form-custom-field', FormCustomField);
});
