document.addEventListener('DOMContentLoaded', function() {
    const gameNames = [
      "Fornite", 
      "Apex Legends", 
      "Squad", 
      "Rust", 
      "EFT", 
    ];
  
    const textElement = document.getElementById("dynamic-game-name");
    let currentGameIndex = 0;
  
    function typeGameName() {
      const gameName = gameNames[currentGameIndex];
      let i = 0;
      const typingSpeed = 150;
      const deletingSpeed = typingSpeed / 2; // Deleting at twice the speed
  
      function type() {
        if (i < gameName.length) {
          textElement.innerHTML = `Selling top tier cheats for ${gameName.substring(0, i + 1)}<span class="typing-cursor">|</span>`;
          i++;
          setTimeout(type, typingSpeed);
        } else {
          setTimeout(deleteGameName, 1000);
        }
      }
  
      function deleteGameName() {
        if (i >= 0) { // Changed condition here to include first letter
          textElement.innerHTML = `Selling top tier cheats for ${gameName.substring(0, i)}<span class="typing-cursor">|</span>`;
          i--;
          setTimeout(deleteGameName, deletingSpeed);
        } else {
          // Move to the next game name after a short pause
          currentGameIndex = (currentGameIndex + 1) % gameNames.length;
          setTimeout(typeGameName, 500); // Adjust the pause as needed
        }
      }
      
      type();
    }
  
    typeGameName();
  });