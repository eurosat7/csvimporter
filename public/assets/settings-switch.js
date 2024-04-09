document.querySelectorAll('div.settings-switch').forEach(
    (settingswitch) => {
        settingswitch.addEventListener('click', async function () {
            if (settingswitch.classList.contains('switching')) {
                return;
            }
            settingswitch.classList.add('switching');
            const id = settingswitch.dataset.id;
            settingswitch.classList.toggle('switched-on');
            const status = settingswitch.classList.contains('switched-on') ? '1' : '-1';
            await fetch('settings-set.php?id=' + id + '&status=' + status);
            settingswitch.classList.remove('switching');
        });
    }
);
