import {html, LitElement} from '/public_html/src/lib/lit/lit-core.min.js';

class Footer extends LitElement
{
    createRenderRoot() {
        return this;
    }
    render()
    {
        return html`
            <div style="max-width:1024px" class="ms-auto me-auto shadow-sm">
                <footer class="m-2 py-2 px-3 rounded-3 bg-body-tertiary bg-opacity-50">
                    <a href="/about">About</a>
                    <div class="bg-body-secondary rounded-3 text-center p-1">
                        <span class="small">
                            © luan004
                        </span>
                    </div>
                </footer>
            </div>
        `;
    }
}

customElements.define('x-component-footer', Footer);