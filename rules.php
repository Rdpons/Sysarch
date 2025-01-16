<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Rules and Regulations</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon">
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
		:root{
			--black: #2c2b30;
			--gray: #4f4f51;
			--white: #fff;
			--pink: #f2c4ce;
			--orange: #f58f7c;
			--bg: linear-gradient(180deg, rgba(116,6,233,0.68) 0%, rgba(175,123,125,0.49343487394957986) 47%, rgba(241,255,3,0.68) 100%);
		}
		*{
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: 'Poppins', sans-serif;
		}

		body{
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
			background: var(--bg);
		}

		.lab-rules-card {
			background-color: var(--white);
			border: none;
			border-radius: 10px;
			padding: 20px;
			margin: 20px;
			max-width: 800px;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
		}

		.lab-rules-card h2 {
			text-align: center;
			font-size: 1.5em;
			margin-bottom: 10px;
			color: var(--black);
		}

		.lab-rules-card h3 {
			font-size: 1.2em;
			margin-top: 15px;
			margin-bottom: 5px;
			color: var(--black);
		}

		.lab-rules-card p {
			line-height: 1.5;
			color: var(--black);
		}

		.lab-rules-card hr {
			margin: 20px 0;
			border: none;
			border-top: 1px solid var(--gray);
		}
        .uc{
            display: flex;
            justify-content: space-around;
            gap: 550px;
        }
        .title{
            text-align: center;
            margin-top: -100px;
        }
        .title h1{
            font-size: 40px;
        }
        .title p{
            font-size: 20px;
            font-weight: 600;
        }
        .labrules{
            text-align: center;
        }
        .labrules h1{
            font-size: 25px;
            margin-bottom: 5px;
        }
        .labrules p{
            text-indent: 20px;
            font-size: 16px;
            text-align: left;
            margin-left: 5px;
        }
        .rules{
            margin-left: 10px;
            padding:20px;
        }
        .rules li{
            text-align: justify;
        }
        .lower{
            list-style-type: lower-alpha;
            margin-left: 20px;
        }
        .discaction{
            margin-top: 10px;
        }
        .discaction h1{
            margin-left: -20px;
            margin-bottom: 10px;
            font-size: 20px;

        }
        .discaction li{
            font-weight: 600;
        }
        .discaction span{
            font-weight: normal;
        }
        .button {
            text-align: center;
            margin-top: 20px;
        }

        .button button {
            padding: 10px 20px;
            background-color: var(--black);
            color: var(--white);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .button button:hover {
            background-color: var(--pink);
        }

	</style>
</head>
<body>
	<div class="lab-rules-card">
        <div class="uc">
            <img src="./images/uc.png" alt="" height="100px">
            <img src="./images/ccs.png" alt="" height="100px">
        </div>
        <div class="title">
            <h1>University of Cebu</h1>
            <p>COLLEGE OF INFORMATION & COMPUTER STUDIES</p>
        </div>  
        <br>
        <div class="labrules">
            <h1>LABORATORY RULES AND REGULATIONS</h1>
            <p>To avoid embarrasment and maintain camaraderie
                with your friends and superiors at our <br>laboratories,
                please observe the following:
            </p>
        </div>
        <div class="rules">
            <ol>
                <li>Maintain silence, proper decorum, and discipline inside the 
                    laboratory. Mobile phones, walkmans and other personal pieces 
                    of equipment must be switched off.
                </li>
                <li>Games are not allowed inside the lab. This includes computer-related 
                    games, card games and other games that may disturb the operation of the 
                    lab.
                </li>
                <li>Surfing the Internet is allowed only with the permission of the instructor. 
                    Downloading and installing of software are strictly prohibited.
                </li>  
                <li>Getting access to other websites not related to the course (especially pornographic and illicit sites) 
                    is strictly prohibited.
                </li>  
                <li>Deleting computer files and changing the set-up of the computer is a major offense.
                </li>  
                <li>Observe computer time usage carefully. A fifteen-minute allowance is given for each use. Otherwise, 
                    the unit will be given to those who wish to "sit-in".
                </li>
                <li>Observe proper decorum while inside the laboratory.
                <ol class="lower"> 
                    <li>
                        Do not get inside the lab unless the instructor is present.
                    </li>
                    <li>
                        All bags, knapsacks, and the likes must be deposited at the counter.                    
                    </li>
                    <li>
                        Follow the seating arrangement of your instructor.
                    </li>
                    <li>
                        At the end of class, all software programs must be closed.                    
                    </li>
                    <li>
                        Return all chairs to their proper places after using.
                    </li>
                </li>
                </ol> 
                <li>Chewing gum, eating, drinking, smoking, and other forms of vandalism are prohibited 
                    inside the lab
                </li>  
                <li>Anyone causing a continual disturbance will be asked to leave the lab. Acts or gestures 
                    offensive to the members of the community, including public display of physical intimacy, 
                    are not tolerated.
                </li>
                <li>Persons exhibiting hostile or threatening behavior such as yelling, swearing, or disregarding 
                    requests made by lab personnel will be asked to leave the lab.
                </li>  
                <li>For serious offense, the lab personnel may call the Civil Security Office (CSU) for assistance.
                </li>
                <li>Any technical problem or difficulty must be addressed to the laboratory supervisor, student assistant 
                    or instructor immediately.
                </li>  
            </ol>
            <div class="discaction">
                <h1>DISCIPLINARY ACTION</h1>
                <ul>
                    <li>First Offense <span>- The Head or the Dean or OIC recommends to the Guidance Center for a suspension from classes 
                        for each offender.
                    </span></li>
                    <li>Second and Subsequent Offenses <span>- A recommendation for a heavier sanction will be endorsed to the Guidance Center.
                    </span></li>
                </ul>
            </div>
        </div>
        <div class="button">
        <button id="backButton">Continue</button>
        </div>
    </div>
</body>
<script>
    document.getElementById("backButton").addEventListener("click", function() {
        window.location.href = "home.php";
    });
</script>
</html>
