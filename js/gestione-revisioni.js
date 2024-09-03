const selectAll = document.getElementById("gestrev_select_all");
selectAll.addEventListener("change", function() {
    const checkboxes = document.querySelectorAll('input[name="post_ids[]"]');
    for (const checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
});

const buttons = document.querySelectorAll(".gestrev_toggle_revisions");
for (const button of buttons) {
    button.addEventListener("click", function(e) {
        e.preventDefault();
        const postId = this.getAttribute("data-post-id");
        const detailRow = document.getElementById("gestrev_revisions_" + postId);
        detailRow.classList.toggle('visible');
    });
}
