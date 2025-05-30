<style>
  /*Insert Page OverPlay*/
  #page-overlay {
    opacity: 0;
    top: 0px;
    left: 0px;
    position: fixed;
    background-color: rgba(249, 249, 249, 0.8);
    height: 100%;
    width: 100%;
    z-index: 9998;
    -webkit-transition: opacity 0.2s linear;
    -moz-transition: opacity 0.2s linear;
    transition: opacity 0.2s linear;
  }

  #page-overlay.visible {
    opacity: 1;
    display: none;
  }

  #page-overlay.visible.active,
  #page-overlay.visible.active img {
    display: block;
  }

  #page-overlay.hidden {
    opacity: 0;
    height: 0px;
    width: 0px;
    z-index: -10000;
  }

  #page-overlay .loader {
    margin: auto;
  }

  @-webkit-keyframes loader {
    from {
      transform: rotate(0deg);
    }

    to {
      transform: rotate(360deg);
    }
  }
  @keyframes loader {
    from {
      transform: rotate(0deg);
    }
    to {
      transform: rotate(360deg);
    }
  }
  .loader {
    top: 50%;
    position: relative;
    display: block;
    width: 2.5rem;
    height: 2.5rem;
    color: #206bc4;
    vertical-align: middle;
  }
  .loader::after {
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
    content: '';
    -webkit-animation: loader 600ms infinite linear;
    animation: loader 600ms infinite linear;
    border: 3px solid #8a20db;;
    border-radius: 50%;
    border-right-color: transparent !important;
    border-top-color: transparent !important;
    display: block;
    height: 2.0em;
    width: 2.0em;
    left: calc(50% - (1.4em / 2));
    top: calc(50% - (1.4em / 2));
    -webkit-transform-origin: center;
    transform-origin: center;
    position: absolute !important;
  }
</style>
<div id="page-overlay" class="visible incoming">
  <span class="loader"></span>
</div>