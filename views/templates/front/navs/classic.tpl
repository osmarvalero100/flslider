<style>
.fl-slider .navs {
    position: absolute;
    width: 100%;
    top: 40%;
    font-size: 24px;
}
.fl-slider .classic-nav .prev {
    border-radius: 0 3px 3px 0;
    float: left;
}
.fl-slider .classic-nav .next {
    border-radius: 3px 0 0 3px;
    float: right;
}
.fl-slider .classic-nav a {
    z-index: 4;
    position: relative;
    /* background-color: rgba(0, 0, 0, 0.1); */
    text-decoration: none;
    display: inline-block;
    padding: 9px 9px;
    box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px;
}
.fl-slider .classic-nav a:hover {
    background-color: rgba(0, 0, 0, 0.1);
}
</style>

<div class="classic-nav">
    <a class="prev" href="#" aria-label="Anterior Slide">
        <svg width="24" height="24" xmlns="https://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M20 .755l-14.374 11.245 14.374 11.219-.619.781-15.381-12 15.391-12 .609.755z"/></svg>
    </a>
    <a class="next" href="#" aria-label="Siguiente Slide">
        <svg width="24" height="24" xmlns="https://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M4 .755l14.374 11.245-14.374 11.219.619.781 15.381-12-15.391-12-.609.755z"/></svg>
    </a>
</div>