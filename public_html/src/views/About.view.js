import {html, LitElement} from '/public_html/src/lib/lit/lit-core.min.js';

class About extends LitElement
{
    createRenderRoot() {
        return this;
    }
    render()
    {
        return html`
            <div class="row g-0">
                about
            </div>
        `;
    }
}

customElements.define('x-view-about', About);