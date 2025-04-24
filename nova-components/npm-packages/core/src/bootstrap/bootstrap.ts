import 'reflect-metadata';
import axios from 'axios';
import 'viewerjs/dist/viewer.css';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import $ from 'jquery';
import _ from 'lodash';

window.$ = $;
window.jQuery = $;
window.jquery = $;
window._ = _;
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

library.add(fas);
