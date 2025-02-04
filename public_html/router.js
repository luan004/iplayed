import {html, LitElement} from '/public_html/src/lib/lit/lit-core.min.js';
import Navigo from '/public_html/src/lib/navigo/navigo.es.js';

import './src/views/MainLayout.js';
import './src/views/Login.view.js';

class App extends LitElement {
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
        let router = new Navigo(location.origin)
        router
        .on('/login', () => {
            this.route = html`<x-view-login></x-view-login>`
        })
        .on('*', () => {
            this.route = html`<x-view-main-layout></x-view-main-layout>`
        })
        router.resolve()
    }
    
    render() {
        return html`
        ${this.route}
        `
    }
}
customElements.define('x-app', App)