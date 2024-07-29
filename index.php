<!DOCTYPE html>
<html>
<head>
	<title>Jeep Code Routes</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            
        }
        .default {
            color: black;
        }
        .error-message {
            color: red;
            margin-bottom: 10px;
        }


        .submit-button {
    background-color: #4CAF50; /* Green background color */
    color: white; /* White text color */
    padding: 12px 20px; /* Padding */
    border: none; /* No border */
    border-radius: 4px; /* Rounded corners */
    cursor: pointer; /* Cursor on hover */
    transition: background-color 0.3s; /* Smooth transition on hover */
}

.submit-button:hover {
    background-color: #45a049; /* Darker green on hover */
}


/* Style for the text input */
#jeep_codes {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    transition: border-color 0.3s; /* Smooth transition for border color */
}

/* Style for the text input when focused */
#jeep_codes:focus {
    border-color: #4CAF50; /* Green border color when focused */
    outline: none; /* Remove default focus outline */
}



    </style>



</head>
<body>
	<img class="wave" src="img/wave.png">
	<div class="container">
		<div class="img">
			<img src="img/bg.svg">
            
		</div>
		<div class="login-content">
			<form action="index.html">
				<img src="img/avatar.svg">
                
				<h2 class="title">Jeepney Route</h2>
               
           		<div class="">
           		   <div class="">
           		   		<i class=""></i>
           		   </div>
                      <div class="error-message" id="error-message"></div>
 
            </form>
            <form id="jeepForm" action="" method="post">
        <label for="jeep_codes">Enter Jeep Codes (comma-separated, no spaces):</label><br>
        <input type="text" id="jeep_codes" name="jeep_codes" required><br>
        <pre>

        </pre>
      <button type="submit" class="submit-button">Submit</button>

    
    <pre>


    </pre>
    
    <?php
    function getRoutes() {
        return [
            "01A" => ["Alpha", "Bravo", "Charlie", "Echo", "Golf"],
            "02B" => ["Alpha", "Charlie", "Delta", "Foxtrot", "Golf"],
            "03C" => ["Charlie", "Delta", "Foxtrot", "hotel", "India"],
            "04A" => ["Charlie", "Delta", "Echo", "Foxtrot", "Golf"],
            "04D" => ["Charlie", "Echo", "Foxtrot", "Golf", "India"],
            "06B" => ["Delta", "Hotel", "Juliet", "Kilo", "Lima"],
            "06D" => ["Delta", "Foxtrot", "Golf", "India", "Kilo"],
            "10C" => ["Foxtrot", "Golf", "Hotel", "India", "Juliet"],
            "10H" => ["Foxtrot", "Hotel", "Juliet", "Lima", "Novembar"],
            "11A" => ["Foxtrot", "Golf", "Kilo", "Mike", "November"],
            "11B" => ["Foxtrot", "Golf", "Lima", "Oscar", "Papa"],
            "20A" => ["India", "Juliet", "November", "Papa", "Romeo"],
            "20C" => ["India", "Kilo", "Lima", "Mike", "Romeo"],
            "42C" => ["Juliet", "Kilo", "Lima", "Mike", "Oscar"],
            "42D" => ["Juliet", "November", "Oscar", "Quebec", "Romeo"]
        ];
    }

    

    function displayRoutes($jeepCodes) {
        global $routes; // Define $routes as a global variable
    
        $routes = getRoutes(); // Retrieve routes
    
        $codeRoutes = explode(",", $jeepCodes);
        $numberOfInputs = count($codeRoutes);
    
        // Check if the number of inputs is between 1 and 3
        if ($numberOfInputs >= 1 && $numberOfInputs <= 3) {
            // Get the places for each route
            $allPlaces = [];
            foreach ($codeRoutes as $code) {
                $allPlaces[$code] = $routes[$code];
            }
    
            // Find common places among all routes
            $commonPlaces = $allPlaces[$codeRoutes[0]]; // Initialize with the first route's places
            foreach ($allPlaces as $places) {
                $commonPlaces = array_intersect($commonPlaces, $places);
            }
    
            // Define colors for common places dynamically
            $commonColors = [];
            $availableColors = ["red", "blue", "green", "purple", "orange", "cyan", "magenta", "yellow", "brown", "gray", "pink","violet","maroon","aqua","lime","rose","tan" ];
            $colorIndex = 0;
            foreach ($commonPlaces as $place) {
                $commonColors[$place] = $availableColors[$colorIndex % count($availableColors)];
                $colorIndex++;
            }
    
            // Output the table
            echo "<table>";
            echo "<tr><th>Jeep Code</th><th>Route</th></tr>";
            foreach ($allPlaces as $code => $places) {
                echo "<tr>";
                echo "<td>$code</td>";
                echo "<td>";
                $routeOutput = "";
                foreach ($places as $place) {
                    if ($numberOfInputs === 1) { // If there's only 1 input, set all places to black
                        $routeOutput .= "<span class='default'>$place</span> -> ";
                    } elseif (isset($commonColors[$place])) {
                        $routeOutput .= "<span style='color:" . $commonColors[$place] . ";'>$place</span> -> ";
                    } else {
                        $routeOutput .= "<span class='default'>$place</span> -> ";
                    }
                }
                // Remove the last arrow and space
                $routeOutput = rtrim($routeOutput, " -> ");
                echo $routeOutput;
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<script>document.querySelector('table').style.display = 'none';</script>"; // Hide the table
        }
    }
    







    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $jeepCodes = $_POST['jeep_codes'];
        displayRoutes($jeepCodes);
    }
    ?>


<script>
        // JavaScript validation
        document.getElementById('jeepForm').addEventListener('submit', function(event) {
            var jeepCodesInput = document.getElementById('jeep_codes').value;
            var regex = /^\d{2}[A-Z](,\d{2}[A-Z])*$/;

            if (!regex.test(jeepCodesInput)) {
                document.getElementById('error-message').innerText = 'Please enter valid Jeep Codes. They should be in the format 2 numeric digits followed by a character (e.g., 01A) separated by commas.';
                event.preventDefault(); // Prevent form submission
            } else {
                document.getElementById('error-message').innerText = ''; // Clear error message if validation succeeds
            }
        });

        // Disable space bar
        document.getElementById('jeep_codes').addEventListener('keydown', function(event) {
            if (event.keyCode === 32) { // keyCode for space bar is 32
                event.preventDefault(); // Prevent default action (typing space)
            }
        });

        // Refresh input and delete table if 4 or more inputs
        document.getElementById('jeep_codes').addEventListener('input', function() {
            var input = this.value.trim();
            var inputCount = input.split(',').length;
            if (inputCount > 3) {
                document.getElementById('jeep_codes').value = ''; // Clear input field
                document.querySelector('table').style.display = 'none'; // Hide the table
                document.getElementById('error-message').innerText = 'Please enter 1-3 Jeep Codes.';
            }
        });

        
    </script>

    
    
    
    </form>


        </div>
    
        </div>


   
	
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>
