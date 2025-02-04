import {html, LitElement} from '/public_html/src/lib/lit/lit-core.min.js';

class Games extends LitElement
{
    createRenderRoot() {
        return this;
    }
    render()
    {
        return html`
            <div class="row g-2">
                <div class="col-4 col-md-3 col-lg-2">
                    <a href="/afds" class="card game-card shadow-sm rounded-3 border-0 p-0 bg-opacity-50">
                        <img src="/public_html/src/assets/dev/cover.jpg" class="card-img rounded-3" alt="...">
                        <div class="card-img-overlay d-flex text-center rounded-3">
                            <span class="mt-auto w-100 h5 text-shadow-sm">Resident Evil 3</span>
                        </div>
                    </a>
                </div>
                <div class="col-4 col-md-3 col-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Title</h3>
                            <p class="card-text">Text</p>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
}

customElements.define('x-view-games', Games);