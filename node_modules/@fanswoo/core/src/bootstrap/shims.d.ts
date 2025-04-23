declare module '*.vue' {
  import Vue from 'vue';
  export default Vue;

  export class printDocument {
  }
}

declare module '@ckeditor/*' {
  const classes: any;
  export default classes;
}

declare module '@vue/composition-api';

declare var jquery: any;
declare var jQuery: any;
declare var $: any;
declare var axios: any;
declare var _: any;
declare var Json: any;
declare var Pusher: any;
declare var Controller: any;
declare var Vuex: any;
declare var VueRouter: any;

interface Window {
  jquery: any;
  jQuery: any;
  $: any;
}
