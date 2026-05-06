<div id="LocationOverlay" class="LocationOverlay">
    <div class="OverlayCard">
        <div class="OverlayHeader">
            <div class="OverlayCloseIcon" onclick="closeOverlay()">
                <img src="../assets/icons/return.svg" alt="Back" class="SvgIcon">
            </div>
            <h2 id="OverlayTitle" class="OverlayTitle">Location Name</h2>
            <div class="OverlayCloseIcon" onclick="closeOverlay()">
                <img src="../assets/icons/close.svg" alt="Close" class="SvgIcon">
            </div>
        </div>
        
        <div class="OverlayImageWrapper">
            <img src="../assets/icons/level-3.svg" alt="Detailed Map" class="OverlayImage">
        </div>
        
        <div class="OverlayBadgeRow">
            <div class="OverlayBadgeLevel">
                <span id="OverlayLevelBadgeText">Level ?</span>
            </div>
            <div class="OverlayBadgeCalendar">
                <img src="../assets/icons/calendar-icon.svg" alt="Timetable" class="SvgIcon OverlayIconWhite">
            </div>
        </div>
        
        <button class="OverlayNavButton" onclick="startNavigation()">
            Navigate to Location
        </button>
    </div>
</div>