document.addEventListener("DOMContentLoaded", function () {
    function expandCard(card) {
        card.classList.add("expanded");
    }

    function collapseCard(card) {
        card.classList.remove("expanded");
    }

    document.querySelectorAll(".food-card").forEach(card => {
        card.addEventListener("mouseover", function () {
            expandCard(this);
        });
        card.addEventListener("mouseleave", function () {
            collapseCard(this);
        });
    });
});
