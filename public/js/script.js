$(document).ready(function () {
    var blogId = <?= json_encode($blogId) ?>; // Ensure safe JSON encoding

    // Load Blog Details
    $.get("/myphpproject/app/controllers/blog_detail_api.php", { id: blogId }, function (response) {
        console.log("Blog API Response:", response);

        if (response.status === "success") {
            $(".blog-title").text(response.blog.title);
            $(".blog-content").html(response.blog.content.replace(/\r\n/g, "<br>"));
            $("#like-count").text(response.blog.likes);

            if (response.blog.image) {
                $(".blog-image").attr("src", "/myphpproject/" + response.blog.image).removeClass("d-none");
            }
        } else {
            $(".blog-title").text("Blog Not Found");
            $(".blog-content").html("<p>Error: " + response.message + "</p>");
        }
    }, "json").fail(function (jqXHR, textStatus, errorThrown) {
        console.error("Blog API Error:", textStatus, errorThrown, jqXHR.responseText);
    });

    // Load Comments
    function loadComments() {
        $.get("/myphpproject/app/controllers/comments_api.php", { blog_id: blogId }, function (response) {
            console.log("Comments API Response:", response);

            if (response.status === "success") {
                $("#comment-list").html("");
                response.comments.forEach(comment => {
                    $("#comment-list").append(`
                        <div class="comment">
                            <strong>${comment.username}</strong> <small class="text-muted">${comment.created_at}</small>
                            <p>${comment.comment}</p>
                        </div>
                    `);
                });
            } else {
                $("#comment-list").html("<p>No comments yet. Be the first to comment!</p>");
            }
        }, "json").fail(function (jqXHR, textStatus, errorThrown) {
            console.error("Comments API Error:", textStatus, errorThrown, jqXHR.responseText);
        });
    }
    loadComments();

    // Submit Comment
    $("#submit-comment").click(function () {
        var name = $("#guest-name").val().trim();
        var comment = $("#guest-comment").val().trim();

        if (name === "" || comment === "") {
            alert("Both fields are required!");
            return;
        }

        $.post("/myphpproject/app/controllers/add_comment_api.php", 
            { blog_id: blogId, username: name, comment: comment }, 
            function (response) {
                console.log("Add Comment API Response:", response);

                if (response.status === "success") {
                    alert("Comment added successfully!");
                    $("#guest-name").val("");
                    $("#guest-comment").val("");
                    loadComments();
                } else {
                    alert("Error: " + response.message);
                }
            }, 
            "json"
        ).fail(function (jqXHR, textStatus, errorThrown) {
            console.error("Add Comment API Error:", textStatus, errorThrown, jqXHR.responseText);
        });
    });

    // Handle Like Button Click
    $("#like-button").click(function () {
        $.post("/myphpproject/app/controllers/like_api.php", { blog_id: blogId }, function (response) {
            console.log("Like API Response:", response);

            if (response.status === "success") {
                var newLikes = parseInt($("#like-count").text()) + 1;
                $("#like-count").text(newLikes);
            } else {
                alert("Error: " + response.message);
            }
        }, "json").fail(function (jqXHR, textStatus, errorThrown) {
            console.error("Like API Error:", textStatus, errorThrown, jqXHR.responseText);
        });
    });
});
