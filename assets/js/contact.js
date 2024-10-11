let form = document.getElementById("format");

form.addEventListener("submit", (e) => {
  e.preventDefault(); // Prevent the default form submission

  // Create an XMLHttpRequest object
  let req = new XMLHttpRequest();

  // Open a POST request to the PHP script
  req.open("POST", "contact.php", true);

  // Set the onload function to handle the response
  req.onload = () => {
    if (req.status === 200) {
      // Show success message
      document.querySelector('.sent-message').style.display = 'block';
      console.log("Request successful:", req.responseText);
    } else {
      console.log("Error:", req.status, req.statusText);
    }
  };

  // Handle errors
  req.onerror = () => {
    console.log("Request failed");
  };

  // Collect form data
  let formData = new FormData(form);

  // Send the form data via AJAX
  req.send(formData);

 
});
