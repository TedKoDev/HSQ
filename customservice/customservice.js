// 화면 모두 로드되면 토큰 보내서 유저 정보 받아오기
async function sendToken() {
  // 서버에 토큰값 전달
  postToken(tokenValue);

  console.log("testst1");
}

getPosts();

//fetch api getPosets
async function getPosts() {
  const response = await fetch("customservice.php");
  const data = await response.json();
  console.log(data);
  for (var i = 0; i < data.post.length; i++) {
    var post = data.post[i];
    var html =
      '<div class="flex justify-between items-center mb-6"  data-post-id="' +
      post.post_id +
      '">';
    html += '<div class="w-1/4 text-center">' + post.post_id + "</div>";
    html += '<div class="w-1/4 text-center">' + post.category + "</div>";
    html += '<div class="w-1/4 text-center">' + post.title + "</div>";
    html += '<div class="w-1/4 text-center">' + post.author + "</div>";
    html += '<div class="w-1/4 text-center">' + post.post_date + "</div>";
    html += "</div>";
    document.getElementById("posts").innerHTML += html;
  }

  const elements = document.querySelectorAll(".mb-6");
  elements.forEach((element) => {
    element.addEventListener("click", (event) => {
      // const postId = event.target.getAttribute("data-post-id");

      const postId = event.target
        .closest("[data-post-id]")
        .getAttribute("data-post-id");
      console.log(`Post ID: ${postId}`);
      openDetailPage(postId);
    });
  });
}
function openDetailPage(postId) {
  // Redirect the user to the detail page
  window.location.href = `detailpage.php?post_id=${postId}`;
}

// clickeventlistener for write page button
document.getElementById("write").addEventListener("click", writePage);

//fetch move to write page button
function writePage() {
  window.location.href = "writepage.php";
}
