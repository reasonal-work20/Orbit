<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Directory </title>
    <link rel="stylesheet" href="../styles/nav-map.css">
    <link rel="stylesheet" href="../styles/nav-bar.css">
    <link rel="stylesheet" href="../styles/location-overlay.css">
</head>

<body>
    <?php include 'nav-bar.php'; ?>

    <div class="AppWrapper">
        <main class="MainLayout">
            <div class="ContentCard">
                
                <aside class="Sidebar">
                    <div class="SearchSection">
                        <div class="SearchBar">
                            <div class="SearchIconWrapper">
                                <div class="SearchIconBox">
                                    <img src="../assets/icons/search-icon.svg" alt="Search Icon" class="SvgIcon">
                                </div>
                            </div>
                        <input type="text" class="SearchInput" placeholder="Search by landmark or location">
                        </div>
                    </div>
                    
                    <div class="FilterRow">
                        <div class="BtnLevel" style="position: relative; cursor: pointer;" onclick="document.getElementById('LevelMenu').style.display = document.getElementById('LevelMenu').style.display === 'none' ? 'flex' : 'none';">
                            <div class="BtnText" id="SelectedLevel">Level 3</div>
                            <div class="BtnIconWrapper">
                                <img src="../assets/icons/drop-down-arrow.svg" alt="Dropdown Arrow" class="SvgIcon">
                            </div>
                            
                            <div id="LevelMenu" class="LevelDropdown" style="display: none; top: 100%; margin-top: 5px;">
                                
                                <div class="LevelRow" onclick="selectLevel(this, 'Level 3')"><div class="LevelText Active">Level 3</div></div>
                                <div class="LevelRow" onclick="selectLevel(this, 'Level 4')"><div class="LevelText">Level 4</div></div>
                                <div class="LevelRow" onclick="selectLevel(this, 'Level 5')"><div class="LevelText">Level 5</div></div>
                                <div class="LevelRow" onclick="selectLevel(this, 'Level 6')"><div class="LevelText">Level 6</div></div>
                                <div class="LevelRow" onclick="selectLevel(this, 'Level 7')"><div class="LevelText">Level 7</div></div>
                                <div class="LevelRow" onclick="selectLevel(this, 'Level 8')"><div class="LevelText">Level 8</div></div>
                                <div class="LevelRow" onclick="selectLevel(this, 'Level 9')"><div class="LevelText">Level 9</div></div>
                

                            </div>
                        </div>  
                        <div style="position: relative;">
                            <div class="BtnFilter" style="cursor: pointer;" onclick="toggleFilterMenu()">
                                <div class="BtnIconBox">
                                    <img src="../assets/icons/filter-icon.svg" alt="Search Icon" class="SvgIcon">
                                </div>
                                <div class="BtnText">Filter</div>
                            </div>
                            
                            <div id="FilterMenu" class="FilterDropdown" style="display: none;">
                                
                                <div class="FilterHeader">
                                    <div class="FilterTitle">Filter by</div>
                                    <div class="FilterReset">Reset all</div>
                                </div>

                                <div class="FilterSection">
                                    <div class="FilterSectionTitle">Location Types</div>
                                    
                                    <div class="FilterOption" onclick="toggleCheckbox(this)">
                                        <div class="FilterLabel">Show Classrooms</div>
                                        <div class="CheckboxChecked"></div>
                                    </div>
                                    
                                    <div class="FilterOption" onclick="toggleCheckbox(this)">
                                        <div class="FilterLabel">Show Auditoriums</div>
                                        <div class="CheckboxUnchecked"></div>
                                    </div>
                                    
                                    <div class="FilterOption" onclick="toggleCheckbox(this)">
                                        <div class="FilterLabel">Show Tech Labs</div>
                                        <div class="CheckboxUnchecked"></div>
                                    </div>
                                    
                                    <div class="FilterOption" onclick="toggleCheckbox(this)">
                                        <div class="FilterLabel">Show Other Facilities</div>
                                        <div class="CheckboxUnchecked"></div>
                                    </div>
                                </div>

                                <div class="FilterSection">
                                    <div class="FilterSectionTitle">Route Preferences</div>
                                    
                                    <div class="FilterOption Padded" onclick="selectRadio(this)">
                                        <div class="FilterLabel">Staircase & Elevator</div>
                                        <div class="RadioChecked"><div class="RadioCheckedInner"></div></div>
                                    </div>
                                    
                                    <div class="FilterOption Padded" onclick="selectRadio(this)">
                                        <div class="FilterLabel">Elevator Only</div>
                                        <div class="RadioUnchecked"></div>
                                    </div>
                                    
                                    <div class="FilterOption Padded" onclick="selectRadio(this)">
                                        <div class="FilterLabel">Emergency Exits</div>
                                        <div class="RadioUnchecked"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="RoutingSection" id="RoutingSection" style="display: none;">
                        <div class="RouteBox">
                            <span class="RouteLabel">To:</span>
                            <span class="RouteDestination" id="RouteDestinationText">Auditorium 1</span>
                        </div>
                        <div class="RouteBox">
                            <input type="text" class="RouteInput" placeholder="From: Change Start Location">
                            <div class="RouteIconBox">
                                <img src="../assets/icons/search-icon.svg" alt="Search" class="SvgIcon">
                            </div>
                        </div>
                    </div>
                    
                    <div class="DirectoryList">
                        <div class="DirectoryItem DirectoryItemCenter" onclick="openOverlay(this)">
                            <div class="ItemName">Administrator’s Office</div>
                            <div class="Badge"><div class="BadgeText">L4</div></div>
                        </div>
                        <div class="DirectoryItem" onclick="openOverlay(this)">
                            <div class="ItemName">Auditorium 1</div>
                            <div class="Badge"><div class="BadgeText">L7</div></div>
                        </div>
                        <div class="DirectoryItem DirectoryItemCenter" onclick="openOverlay(this)">
                            <div class="ItemName">Auditorium 2</div>
                            <div class="Badge"><div class="BadgeText">L6</div></div>
                        </div>
                        <div class="DirectoryItem DirectoryItemCenter" onclick="openOverlay(this)">
                            <div class="ItemName">Auditorium 3</div>
                            <div class="Badge"><div class="BadgeText">L3</div></div>
                        </div>
                        <div class="DirectoryItem" onclick="openOverlay(this)">
                            <div class="ItemName">Auditorium 4</div>
                            <div class="Badge"><div class="BadgeText">L3</div></div>
                        </div>
                        <div class="DirectoryItem" onclick="openOverlay(this)">
                            <div class="ItemName">Auditorium 5</div>
                            <div class="Badge"><div class="BadgeText">L3</div></div>
                        </div>
                        <div class="DirectoryItem" onclick="openOverlay(this)">
                            <div class="ItemName">Auditorium 6</div>
                            <div class="Badge"><div class="BadgeText">L4</div></div>
                        </div>
                        <div class="DirectoryItem" onclick="openOverlay(this)">
                            <div class="ItemName">Bila-Bila Mart</div>
                            <div class="Badge"><div class="BadgeText">L3</div></div>
                        </div>
                        <div class="DirectoryItem" onclick="openOverlay(this)">
                            <div class="ItemName">B-04-01</div>
                            <div class="Badge"><div class="BadgeText">L4</div></div>
                        </div>
                        <div class="DirectoryItem" onclick="openOverlay(this)">
                            <div class="ItemName">B-04-02</div>
                            <div class="Badge"><div class="BadgeText">L4</div></div>
                        </div>
                        <div class="DirectoryItem" onclick="openOverlay(this)">
                            <div class="ItemName">B-04-03</div>
                            <div class="Badge"><div class="BadgeText">L4</div></div>
                        </div>
                        <div class="DirectoryItem" onclick="openOverlay(this)">
                            <div class="ItemName">Cafeteria</div>
                            <div class="Badge"><div class="BadgeText">L3</div></div>
                        </div>
                    </div>
                </aside>

                <section class="MapSection">
                    <div class="MapImageWrapper">
                        <img class="MapImage" src="../assets/icons/level-3.svg" alt="Map View" />
                    </div>
                </section>


                
            </div> </main> </div> 

    <?php include 'location-overlay.php'; ?>

    <script>
        function selectLevel(element, levelText) {
            // Update the dropdown button text
            document.getElementById('SelectedLevel').innerText = levelText;
            
            // Remove 'Active' class from all options
            const allLevels = document.querySelectorAll('#LevelMenu .LevelText');
            allLevels.forEach(el => el.classList.remove('Active'));
            
            // Add 'Active' class to the clicked option
            element.querySelector('.LevelText').classList.add('Active');
        }

        // Toggles the visibility of the Filter Dropdown
        function toggleFilterMenu() {
            const menu = document.getElementById('FilterMenu');
            menu.style.display = menu.style.display === 'none' ? 'flex' : 'none';
        }

        // Handles toggling checkboxes on and off
        function toggleCheckbox(element) {
            const checkbox = element.children[1];
            if (checkbox.className === 'CheckboxChecked') {
                checkbox.className = 'CheckboxUnchecked';
            } else {
                checkbox.className = 'CheckboxChecked';
            }
        }

        // Handles swapping active radio buttons in a section
        function selectRadio(element) {
            const section = element.parentElement;
            const options = section.querySelectorAll('.FilterOption');
            options.forEach(opt => {
                const radio = opt.children[1];
                radio.className = 'RadioUnchecked';
                radio.innerHTML = '';
            });
            const clickedRadio = element.children[1];
            clickedRadio.className = 'RadioChecked';
            clickedRadio.innerHTML = '<div class="RadioCheckedInner"></div>';
        }

        // Opens the overlay and dynamically sets the title and level
        function openOverlay(element) {
            const overlay = document.getElementById('LocationOverlay');
            overlay.style.display = 'flex';
            document.body.classList.add('OverlayOpen'); // Prevent scrolling

            if (element) {
                const itemName = element.querySelector('.ItemName').innerText;
                const badgeText = element.querySelector('.BadgeText').innerText;
                
                document.getElementById('OverlayTitle').innerText = itemName;
                document.getElementById('OverlayLevelBadgeText').innerText = 'Level ' + badgeText.replace('L', '');
            }
        }

        
        function closeOverlay() {
            const overlay = document.getElementById('LocationOverlay');
            overlay.style.display = 'none';
            document.body.classList.remove('OverlayOpen'); // Re-enable scrolling
        }


        function startNavigation() {
            const destinationName = document.getElementById('OverlayTitle').innerText;
            document.getElementById('RouteDestinationText').innerText = destinationName;
            document.querySelector('.SearchSection').style.display = 'none';
            document.querySelector('.FilterRow').style.display = 'none';
            document.getElementById('RoutingSection').style.display = 'flex';
            closeOverlay();
        }
    </script>
</body>
</html>