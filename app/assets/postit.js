
window.addEventListener("load", (event) => {
  // Get references to the necessary DOM elements
  let button = document.getElementById('revButton');
  let revForm = document.getElementById('revForm');
  let thumbUpBtn = document.getElementById('thumbUp');
  let thumbDnBtn = document.getElementById('thumbDn');
  let userRating = document.getElementById('userRating');
  let tUpImg = document.getElementById('tUp');
  let tDnImg = document.getElementById('tDn');
  let reviewContainers = document.querySelectorAll('.mb-3');
  let postFeedback = document.getElementById('postFeedback');


  // Function to hide and show the comment form
  button.addEventListener("click", () => {
    if (revForm.style.display === "none" || revForm.style.display === "") {
      revForm.style.display = "block"; // Show the form
      revForm.scrollIntoView({ behavior: "smooth", block: "start" }); // Scroll down to the form
    } else {
      revForm.style.display = "none"; // Hide the form
    }

  });

  // Handle the thumbs up button clicks
  thumbUpBtn.addEventListener("click", () => {
    if (tUpImg.src.includes("thmUpWtLg.png")) {
      tUpImg.src = "/imgs/thmUpGrLg.png"; // Change to green thumbs up image
      userRating.value = 1; // Set user rating to 1

    } else {
      tUpImg.src = "/imgs/thmUpWtLg.png"; // Change back to white thumbs up image
      userRating.value = ""; // Reset user rating

    }

    tDnImg.src = "/imgs/thmDnWtLg.png"; // Reset thumbs down image to white
  });

  // Handle the thumbs down button clicks
  thumbDnBtn.addEventListener("click", () => {
    if (tDnImg.src.includes("thmDnWtLg.png")) {
      tDnImg.src = "/imgs/thmDnRdLg.png"; // Change to red thumbs down image
      userRating.value = 0; // Set user rating to 0

    } else {
      tDnImg.src = "/imgs/thmDnWtLg.png"; // Change back to white thumbs down image
      userRating.value = ""; // Reset user rating

    }

    tUpImg.src = "/imgs/thmUpWtLg.png"; // Reset thumbs up image to white
  });

  // Change the thumbs up and down images in each review based on the value passed into the hidden div
  reviewContainers.forEach(container => {
    // Get the hidden div and the img element within the current container
    let hiddenDiv = container.querySelector('.hidden');
    let imgElement = container.querySelector('.ratingImg');

    // Get the value from the hidden div
    let thumbValue = hiddenDiv.textContent.trim();

    // Set the img src based on the value
    if (thumbValue === '1') {
      imgElement.src = '/imgs/thmUpGrsm.png'; // Set to green thumbs up image
    } else if (thumbValue === '0') {
      imgElement.src = '/imgs/thmDnRdSm.png'; // Set to red thumbs down image
    }
  });


  setTimeout(()=>{
    if(postFeedback)
      {
        postFeedback.style.display = "none"
      }
  },3000);




});
