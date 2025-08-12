document.addEventListener("DOMContentLoaded", function () {
    // Sidebar Toggle
    const sidebar = document.querySelector(".sidebar");
    const toggleBtn = document.createElement("button");
    toggleBtn.classList.add("toggle-btn");
    toggleBtn.innerHTML = "<i class='fas fa-bars'></i>";
    sidebar.appendChild(toggleBtn);

    toggleBtn.addEventListener("click", function () {
        sidebar.classList.toggle("collapsed");
        localStorage.setItem("sidebarState", sidebar.classList.contains("collapsed") ? "collapsed" : "expanded");
    });

    // Preserve Sidebar State
    if (localStorage.getItem("sidebarState") === "collapsed") {
        sidebar.classList.add("collapsed");
    }

    // Dynamic Content Loading (Optional)
    function loadPage(page) {
        fetch("index.php?page=" + page)
            .then(response => response.text())
            .then(data => {
                document.getElementById("content").innerHTML = data;
                window.history.pushState({}, "", "index.php?page=" + page);
            })
            .catch(error => {
                document.getElementById("content").innerHTML = "<h2 class='text-danger text-center mt-5'>404 - Page Not Found</h2>";
            });
    }

    // Handle Back Button Navigation
    window.onpopstate = function () {
        const urlParams = new URLSearchParams(window.location.search);
        const page = urlParams.get('page') || 'dashboard';
        loadPage(page);
    };
});
    

$(document).ready(function () {
            $("#submitComment").click(function (e) {
                e.preventDefault();

                let blogId = $("#blog_id").val();
                let username = $("#username").val();
                let comment = $("#comment").val();

                if (!blogId || !username || !comment) {
                    alert("All fields are required!");
                    return;
                }

                $.ajax({
                    url: "app/controllers/add_comment_api.php",
                    type: "POST",
                    data: { blog_id: blogId, username: username, comment: comment },
                    dataType: "json",
                    success: function (response) {
                        if (response.status === "success") {
                            alert("Comment added successfully!");
                            location.reload(); // Reload to show new comment
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            });
        });
   $(document).ready(function () {
    $(".like-button").click(function (e) {
        e.preventDefault();
        
        let blogId = $(this).data("blog-id"); // Get blog ID from button
        let likeCountElement = $(this).siblings(".like-count"); // Find the like count display

        $.ajax({
            url: "app/controllers/like_api.php",
            type: "POST",
            data: { blog_id: blogId },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    let newLikeCount = response.likes;
                    likeCountElement.text(newLikeCount); // Update like count
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    });
});





