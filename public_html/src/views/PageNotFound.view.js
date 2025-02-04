import {html, LitElement} from '/public_html/src/lib/lit/lit-core.min.js';

class PageNotFound extends LitElement
{
    createRenderRoot() {
        return this;
    }
    
    render()
    {
        return html`
            <div class="h-100 bold d-flex flex-column align-items-center justify-content-center">
                <h1>404</h1>
                <p class="opacity-50">Essa página não existe</p>
            </div>
        `;
    }
}

customElements.define('x-view-pagenotfound', PageNotFound);