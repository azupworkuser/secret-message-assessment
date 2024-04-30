import './bootstrap';

import $ from "jquery";
window.jQuery = window.$ = $;

import * as bootstrap from 'bootstrap'
import moment from 'moment';
window.Moment = moment;

import DataTable from 'datatables.net-bs5';
window.DataTable = DataTable;

import * as encryption from './encryption';
window.Encryption = encryption;

import * as store from './store';
window.Store = store;