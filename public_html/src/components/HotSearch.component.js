import {html, LitElement} from '/public_html/src/lib/lit/lit-core.min.js';

class HotSearch extends LitElement
{
    createRenderRoot() {
        return this;
    }
    render()
    {
        return html`
            <div style="max-width:1024px" class="ms-auto me-auto shadow-sm">
                <div class="m-2 py-2 px-3 rounded-3 bg-body-tertiary bg-opacity-50">
                    teste
                </div>
            </div>
        `;
    }
}

customElements.define('x-component-hot-search', HotSearch);