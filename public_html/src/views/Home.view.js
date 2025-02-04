import {html, LitElement} from '/public_html/src/lib/lit/lit-core.min.js';

class Home extends LitElement
{
    createRenderRoot() {
        return this;
    }
    render()
    {
        return html`
            <div class="row g-0">
                home
            </div>
        `;
    }
}

customElements.define('x-view-home', Home);