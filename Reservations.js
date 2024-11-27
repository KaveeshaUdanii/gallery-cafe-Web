document.querySelector('.reservation-form').addEventListener('submit', function (event) {
    const uid = document.querySelector('input[name="UID"]').value;
    const persons = document.querySelector('input[name="persons"]').value;
    const date = document.querySelector('input[name="date"]').value;
    const time = document.querySelector('input[name="time"]').value;

    if (!uid || !persons || !date || !time) {
        alert("Please fill in all required fields.");
        event.preventDefault(); // Prevent form submission if fields are empty
    }
});
