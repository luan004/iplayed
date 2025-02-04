import {html, LitElement} from '/public_html/src/lib/lit/lit-core.min.js';

class NavBar extends LitElement
{
    constructor() {
        super();
        this.actualPage = location.pathname;
    }
    createRenderRoot() {
        return this;
    }
    render()
    {
        return html`
            <div style="max-width:1024px" class="ms-auto me-auto fixed-top">
                <nav class="m-2 navbar navbar-expand-lg bg-body-tertiary shadow-sm rounded-3 py-2 px-3 bg-opacity-50" style="backdrop-filter: blur(15px);">
                    <div class="container-fluid p-0">
                        <a class="navbar-brand">iPlayed</a>
                        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link ${this.actualPage === '/games' ? 'active' : ''}" aria-current="page" href="/games">Jogos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ${this.actualPage === '/platforms' ? 'active' : ''}" href="/platforms">Plataformas</a>
                                </li>
                            </ul>
                            <form class="d-flex" role="search">
                                <input class="shadow-sm form-control rounded-pill border-0 bg-secondary bg-opacity-25" type="search" placeholder="Buscar..." aria-label="Buscar">
                                <div class="hotsearch-box p-4 border position-absolute">

                                </div>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        `;
    }
}

customElements.define('x-component-navbar', NavBar);