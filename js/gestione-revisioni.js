document.getElementById("gr_select_all").addEventListener("change", function(e) {
    var checkboxes = document.querySelectorAll('input[name="post_ids[]"]');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = this.checked;
    }
});

document.querySelectorAll(".gr_toggle_revisions").forEach(function(button) {
    button.addEventListener("click", function(e) {
        e.preventDefault();
        var postId = this.getAttribute("data-post-id");
        var detailRow = document.getElementById("gr_revisions_" + postId);
        detailRow.style.display = (detailRow.style.display === "none" || detailRow.style.display === "") ? "flex" : "none";
    });
});
