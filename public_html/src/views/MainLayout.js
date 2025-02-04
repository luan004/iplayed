import {html, LitElement} from '/public_html/src/lib/lit/lit-core.min.js';
import Navigo from '/public_html/src/lib/navigo/navigo.es.js';

import '/public_html/src/views/Home.view.js';
import '/public_html/src/views/Games.view.js';
import '/public_html/src/views/PageNotFound.view.js';

import '/public_html/src/components/NavBar.component.js';
import '/public_html/src/components/HotSearch.component.js';
import '/public_html/src/components/Footer.component.js';

class MainLayout extends LitElement {
  createRenderRoot() {
    return this;
  }
  
  static get properties() {
    return {
      route: { type: Object }
    }
  }

  constructor() {
    super()
    let router = new Navigo(location.origin);  

    router
    .on('/', () => {
      this.route = html`<x-view-home></x-view-home>`
    })
    .on('/games', () => {
        this.route = html`<x-view-games></x-view-games>`
    })
    .on('/*', () => {
      this.route = html`<x-view-pagenotfound></x-view-pagenotfound>`
    })
    router.resolve()
  }
  render() {
    return html`
    <x-component-navbar></x-component-navbar>
    <div class="h-100 ms-auto me-auto" style="max-width:1024px;">
      <div class="h-100 mx-2" style="margin-top:72px;">
        ${this.route}
      </div>
    </div>
    <x-component-footer></x-component-footer>
    `
  }
}

customElements.define('x-view-main-layout', MainLayout);
