import { App } from '@inertiajs/inertia-react';
import React from 'react';
import { render } from 'react-dom';
import 'antd/dist/antd.css';
require('./bootstrap');
require('alpinejs');

const el = document.getElementById('app');

render(
  <App
    initialPage={JSON.parse(el.dataset.page)}
    resolveComponent={name => require(`./Pages/${name}`).default}
  />,
  el
)
