const features = document.querySelectorAll(".feature-dropdown");

let featureHeight;

features.forEach(feature => {
    feature.addEventListener("click", () => {
        feature.classList.toggle("feature-dropdown-active");
        featureHeight = feature.scrollHeight;
        
        if(feature.classList.contains("feature-dropdown-active")) {
            feature.style.height = `${featureHeight}px`;
        } else {
            feature.style.height = "3rem";
        }
    });
});

