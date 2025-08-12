<?php
$blogId = $_GET['id'] ?? 0;
?>
<?php include 'app/views/partials/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 100px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .blog-title {
            font-size: 24px;
            font-weight: bold;
        }
        .blog-content {
            margin-top: 20px;
            line-height: 1.6;
        }
        .comment-box {
            margin-top: 30px;
            padding: 15px;
            background: #f1f1f1;
            border-radius: 5px;
        }
        .comment {
            background: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="blog-title text-center">Loading...</h1>
    <img class="blog-image d-none w-100" alt="Blog Image">
    <p class="blog-content">Loading content...</p>
    <p><strong>Likes:</strong> <span id="like-count">0</span></p>

    <!-- Comment Form -->
    <div class="comment-box">
        <h4>Leave a Comment</h4>
        <div class="mb-3">
            <input type="text" id="guest-name" class="form-control" placeholder="Your Name">
        </div>
        <div class="mb-3">
            <textarea id="guest-comment" class="form-control" rows="4" placeholder="Write your comment..."></textarea>
        </div>
        <button id="submit-comment" type="button" class="btn btn-primary">Submit Comment</button>

    </div>

    <!-- Display Comments -->
    <div class="comments mt-4">
        <h5>Comments</h5>
        <div id="comment-list">
            <p>Loading comments...</p>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
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


</script>
</body>
</html>
