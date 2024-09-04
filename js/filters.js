const games = document.querySelectorAll(".game");
const buttons = document.querySelectorAll(".filter-btn");

function gameFilter(game) {
    if(game === "all") {
        games.forEach(card => {
        card.style.display = "flex";
        });
    } else {
        games.forEach(card => {
            if(card.classList.contains(game)) {
            card.style.display = "flex";
            } else {
            card.style.display = "none";
            }
        });
    }
}

buttons.forEach(button => {
    button.addEventListener("click", () => {
        buttons.forEach(button => {
            button.classList.remove("filter-selected");
        });        
        button.classList.toggle("filter-selected");
    });
});


