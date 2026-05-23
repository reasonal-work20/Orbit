document.addEventListener('DOMContentLoaded', () => {
    const todayTab = document.querySelector('.today');
    const upcomingTab = document.querySelector('.upcoming');
    const todayList = document.querySelector('.class-list');
    const upcomingList = document.querySelector('.upcoming-class-list');

    // Function to handle tab switching
    const switchTab = (activeTab, inactiveTab, activeList, inactiveList) => {
        // Manage tab button states
        activeTab.classList.add('active');
        inactiveTab.classList.remove('active');

        // Manage content list states
        activeList.classList.add('active');
        inactiveList.classList.remove('active');
    };

    // Initialize "TODAY" as active on initial page load
    switchTab(todayTab, upcomingTab, todayList, upcomingList);

    // Event listeners for user interaction
    todayTab.addEventListener('click', () => {
        switchTab(todayTab, upcomingTab, todayList, upcomingList);
    });

    upcomingTab.addEventListener('click', () => {
        switchTab(upcomingTab, todayTab, upcomingList, todayList);
    });
});