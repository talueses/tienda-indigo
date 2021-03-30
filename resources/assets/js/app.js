
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./admin/index');
window.$.fn.DataTable = require('datatables.net');
window.$.fn.DataTable = require('datatables.net-bs4');
require('./admin-datatables');
require('./admin');
require('./admin/inicio.js');
require('./admin/lista-novios.js');
require('./admin/gallery');
require('./vendor/bsdatepicker.min.js');