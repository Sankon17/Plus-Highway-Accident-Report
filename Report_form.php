<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PLUS - Report Accident</title>
    <link rel="stylesheet" href="Report_form.css" >
</head>

<body>

    <header>
        <div class="logo" onclick="window.location.href='Menu.php'">
            <img src="PlusLogo.png" alt="PLUS Logo">
        </div>
        <div class="header-controls">
            <div class="lang-search">
                <span style="color:#0056b3">EN</span> | <span>BM</span> | <span>⚲</span>
            </div>
            <div class="plusline-btn">
                <span>✆ PLUSLine</span>
                <strong>1-800-88-0000</strong>
            </div>
        </div>
    </header>

    <div class="nav-container">
        <button class="nav-btn" onclick="window.location.href='Menu.php'">HOME</button>
        <button class="nav-btn active" onclick="window.location.href='Report_form.php'">REPORT ACCIDENT</button>
        <button class="nav-btn" onclick="window.location.href='Report_search.php'">LIST</button>
        <button class="nav-btn" onclick="window.location.href='User_information.php'">ACCOUNT</button>
    </div>

    <div class="main-container">
        <div class="form-card">
            <h2 style="margin-top:0; border-bottom:1px solid #eee; padding-bottom:15px; margin-bottom:25px;">New
                Incident Report</h2>

            <form action="submit_report.php" method="POST" enctype="multipart/form-data"> <!-- enable user to submit files -->
                <div class="form-row"> <!-- All the details will be saved in the submit_report -->
                    <div class="col">
                        <label>Date & Time</label>
                        <div style="display:flex; gap:10px;">
                            <input type="date" name="date" required>
                            <input type="time" name="time" required>
                        </div>

                        <label>Location (KM)</label>
                        <input type="text" name="location" placeholder="e.g. KM 201.5 Northbound" required>

                        <label>Incident Type</label>
                        <select name="type">
                            <option>Accident</option>
                            <option>Obstruction</option>
                            <option>Pothole</option>
                            <option>Facility Damage</option>
                        </select>

                        <label>Priority Level</label>
                        <select name="priority">
                            <option value="Low">Low</option>
                            <option value="Medium" selected>Medium</option>
                            <option value="High">High</option>
                        </select>

                    </div>

                    <div class="col">
                        <label>Photo Evidence</label>
                        <div class="upload-box" onclick="document.getElementById('fileInput').click()">
                            <input type="file" id="fileInput" name="evidence_photo" hidden accept="image/*">
                            <div id="upload-txt" style="text-align:center;"> <!-- create an invisible button to submit file -->
                                <span style="font-size:24px;">📷</span><br>Click to Upload
                            </div>
                            <img id="preview-img" src="" alt="Preview">
                        </div>

                        <label style="margin-top:20px;">Description</label>
                        <textarea name="description" placeholder="Describe the incident..."
                            style="height:80px;"></textarea>
                    </div>
                </div>

                <button type="submit" class="submit-btn">SUBMIT REPORT</button>
            </form>
        </div>
    </div>

    <script>
    const fileInput = document.getElementById('fileInput');
    const previewImg = document.getElementById('preview-img');
    const uploadTxt = document.getElementById('upload-txt');

    fileInput.addEventListener('change', function() { // replace the camera icon with the image
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
                uploadTxt.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    });
    </script>

</body>

</html>