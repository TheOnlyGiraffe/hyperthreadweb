const medias = document.querySelectorAll(".media");
const initalMedia = document.querySelector(".inital-media");
const cheatNav = document.querySelector(".cheat-nav"); // Find the "cheat-nav" element within the "faq-block"
const button = document.createElement("button"); // Create a button element
button.className = "nav-btn"; // Set the class for the button

const numberOfMediaItems = medias.length;


// Create buttons based on the number of media items
for (let i = 0; i < numberOfMediaItems; i++) {
  const button = document.createElement("button");
  button.className = "nav-btn";
  if (i === 0) {
    button.classList.add("nav-btn-selected");
  }
  cheatNav.appendChild(button);
}

const buttons = document.querySelectorAll(".nav-btn");


buttons.forEach(button => {
    button.addEventListener("click", () => {
        // Pause all playing videos before switching
        document.querySelectorAll('.media iframe').forEach(iframe => {
          const src = iframe.src;
          iframe.src = src; // Resetting the src pauses the video
        });
        buttons.forEach(button => {
           button.classList.remove("nav-btn-selected");
        });
        button.classList.toggle("nav-btn-selected");

        const selectedIndex = Array.from(buttons).indexOf(button);

        const SelectedMedia = medias[selectedIndex];


        medias.forEach(media => {
            media.style.display = "none";
        });
        SelectedMedia.style.display = "block";
    });
});


medias.forEach(media => {
    media.style.display = "none";
});

initalMedia.style.display = "block";