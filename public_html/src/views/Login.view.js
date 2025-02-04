import {html, LitElement} from '/public_html/src/lib/lit/lit-core.min.js';

class Login extends LitElement
{
    createRenderRoot() {
        return this;
    }
    constructor() {
        super();
        document.title = 'iPlayed - Login';
    }
    render()
    {
        return html`
            <div class="h-100 bold d-flex flex-column align-items-center justify-content-center">
                <div class="card">
                    <h1>Login</h1>
                </div>
            </div>
        `;
    }
}

customElements.define('x-view-login', Login);