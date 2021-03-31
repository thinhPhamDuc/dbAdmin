 $(document).ready(function () {
  $(".editBtn").on("click", function () {
    $("#editModal").modal("show");
    $tr = $(this).closest("tr");
    let data = $tr
      .children("td")
      .map(function () {
        return $(this).text();
      })
      .get();
    console.log(data);
    $("#id_upd").val(data[0]);
    $("#updateImg").attr("src", $tr.children(".imgBtn").children().attr("src"));
    $("#name_upd").val(data[2]);
    $("#position_upd").val(data[3]);
    $("#office_upd").val(data[4]);
    $("#age_upd").val(data[5]);
    $("#startDate_upd").val(data[6]);
    $("#salary_upd").val(data[8]);
  });
  $(".deleteBtn").on("click", function () {
    $("#deleteModal").modal("show");
    $tr = $(this).closest("tr");
    let data = $tr
      .children("td")
      .map(function () {
        return $(this).text();
      })
      .get();
    $("#id_del").val(data[0]);
  });

  // User

  $(".editUserBtn").on("click", function () {
    $("#editUser").modal("show");
    $tr = $(this).closest("tr");
    let data = $tr
      .children("td")
      .map(function () {
        return $(this).text();
      })
      .get();
    console.log(data);
    let role_id = $(this).parents("tr").find(".field-role").data("role_id");
    $("#id_editUser").val(data[0]);
    $("#img_editUser").attr(
      "src",
      $tr.children(".imgUserBtn").children().attr("src")
    );
    $("#firstname_editUser").val(data[2]);
    $("#lastname_editUser").val(data[3]);
    $("#email_editUser").val(data[4]);
    $("#role_editUser").val(role_id);
  });
  $(".deleteUserBtn").on("click", function () {
    $("#deleteUser").modal("show");
    $tr = $(this).closest("tr");
    let data = $tr
      .children("td")
      .map(function () {
        return $(this).text();
      })
      .get();
    $("#id_deleteUser").val(data[0]);
  });

  // Product

  $(".editProductBtn").on("click", function () {
    $("#editProduct").modal("show");
    $tr = $(this).closest("tr");
    let data = $tr
      .children("td")
      .map(function () {
        return $(this).text();
      })
      .get();
    console.log(data);
    let category_id = $(this)
      .parents("tr")
      .find(".field-category")
      .data("category_id");
    let tag_id = $(this).parents("tr").find(".field-tag").data("tag_id");
    tag_id = tag_id.split(",");
    $(".form-tag input").prop("checked", false);
    tag_id.forEach(function (value) {
      if (value !== "") {
        $(".form-tag .tag-" + value).prop("checked", true);
      }
    });
    $("#id_editProduct").val(data[0]);
    $("#img_editProduct").attr(
      "src",
      $tr.children(".imgProductBtn").children().attr("src")
    );
    $("#name_editProduct").val(data[2]);
    $("#description_editProduct").val(data[3]);
    $("#category_editProduct").val(category_id);
    $("#price_editProduct").val(data[6]);
  });
  $(".deleteProductBtn").on("click", function () {
    $("#deleteProduct").modal("show");
    $tr = $(this).closest("tr");
    let data = $tr
      .children("td")
      .map(function () {
        return $(this).text();
      })
      .get();
    $("#id_deleteProduct").val(data[0]);
  });

  // Product Tag

  $(".editProductTagBtn").on("click", function () {
    $("#editProductTag").modal("show");
    $tr = $(this).closest("tr");
    let data = $tr
      .children("td")
      .map(function () {
        return $(this).text();
      })
      .get();
    console.log(data);
    $("#id_editProductTag").val(data[0]);
    $("#name_editProductTag").val(data[1]);
  });
  $(".deleteProductTagBtn").on("click", function () {
    $("#deleteProductTag").modal("show");
    $tr = $(this).closest("tr");
    let data = $tr
      .children("td")
      .map(function () {
        return $(this).text();
      })
      .get();
    $("#id_deleteProductTag").val(data[0]);
  });

  // Product Category

  $(".editProductCategoryBtn").on("click", function () {
    $("#editProductCategory").modal("show");
    $tr = $(this).closest("tr");
    let data = $tr
      .children("td")
      .map(function () {
        return $(this).text();
      })
      .get();
    console.log(data);
    $("#id_editProductCategory").val(data[0]);
    $("#name_editProductCategory").val(data[1]);
  });
  $(".deleteProductCategoryBtn").on("click", function () {
    $("#deleteProductCategory").modal("show");
    $tr = $(this).closest("tr");
    let data = $tr
      .children("td")
      .map(function () {
        return $(this).text();
      })
      .get();
    $("#id_deleteProductCategory").val(data[0]);
  });

  // News

  // $(".editNewsBtn").on("click", function () {
  //   $("#editNews").modal("show");
  //   $tr = $(this).closest("tr");
  //   let data = $tr
  //     .children("td")
  //     .map(function () {
  //       return $(this).text();
  //     })
  //     .get();
  //   console.log(data);
  //   let category_id = $(this)
  //     .parents("tr")
  //     .find(".field-category")
  //     .data("category_id");
  //   let tag_id = $(this).parents("tr").find(".field-tag").data("tag_id");
  //   tag_id = tag_id.split(",");
  //   $(".form-tag input").prop("checked", false);
  //   tag_id.forEach(function (value) {
  //     if (value !== "") {
  //       $(".form-tag .tag-" + value).prop("checked", true);
  //     }
  //   });
  //   $("#id_editNews").val(data[0]);
  //   $("#img_editNews").attr(
  //     "src",
  //     $tr.children(".imgNewsBtn").children().attr("src")
  //   );
  //   $("#title_editNews").val(data[2]);
  //   $("#description_editNews").val(data[3]);
  //   CKEDITOR.instances["content_editNews"].setData(data[4]);
  //   $("#author_editNews").val(data[5]);
  //   $("#category_editNews").val(category_id);
  // });
  $("#category_editNews").val($("#category_editNewsVal").val());
  let newsTags = $("#newsTags").html();
  newsTags = newsTags.split(",");
  $(".form-tag input").prop("checked", false);
  newsTags.forEach(function (value) {
    if (value !== "") {
      value = value.trim();
      $(".form-tag .tag-" + value).prop("checked", true);
    }
  });
  $(".deleteNewsBtn").on("click", function () {
    $("#deleteNews").modal("show");
    $tr = $(this).closest("tr");
    let data = $tr
      .children("td")
      .map(function () {
        return $(this).text();
      })
      .get();
    $("#id_deleteNews").val(data[0]);
  });

  // News Category

  $(".editNewsCategoryBtn").on("click", function () {
    $("#editNewsCategory").modal("show");
    $tr = $(this).closest("tr");
    let data = $tr
      .children("td")
      .map(function () {
        return $(this).text();
      })
      .get();
    console.log(data);
    $("#id_editNewsCategory").val(data[0]);
    $("#name_editNewsCategory").val(data[1]);
  });
  $(".deleteNewsCategoryBtn").on("click", function () {
    $("#deleteNewsCategory").modal("show");
    $tr = $(this).closest("tr");
    let data = $tr
      .children("td")
      .map(function () {
        return $(this).text();
      })
      .get();
    $("#id_deleteNewsCategory").val(data[0]);
  });

  // News Tag

  $(".editNewsTagBtn").on("click", function () {
    $("#editNewsTag").modal("show");
    $tr = $(this).closest("tr");
    let data = $tr
      .children("td")
      .map(function () {
        return $(this).text();
      })
      .get();
    console.log(data);
    $("#id_editNewsTag").val(data[0]);
    $("#name_editNewsTag").val(data[1]);
  });
  $(".deleteNewsTagBtn").on("click", function () {
    $("#deleteNewsTag").modal("show");
    $tr = $(this).closest("tr");
    let data = $tr
      .children("td")
      .map(function () {
        return $(this).text();
      })
      .get();
    $("#id_deleteNewsTag").val(data[0]);
  });

  // Role

  $(".deleteRoleBtn").on("click", function () {
    $("#deleteRole").modal("show");
    $tr = $(this).closest("tr");
    const data = $tr
      .children("td")
      .map(function () {
        return $(this).text();
      })
      .get();
    $("#id_deleteRole").val(data[0]);
  });
});

$(".button-info").click(function () {
  $(".button-pass").removeClass("active");
  $(".button-info").addClass("active");
  $(".profile__info").addClass("show active");
  $(".profile__pass").removeClass("show active");
});
$(".button-pass").click(function () {
  $(".button-info").removeClass("active");
  $(".button-pass").addClass("active");
  $(".profile__info").removeClass("show active");
  $(".profile__pass").addClass("show active");
});

$(".perChecked input").each(function () {
  $(this).click(function () {
    if ($(this).prop("checked") === true) {
      $(this).parent().next().children().prop("checked", true);
      $(this).parent().next().next().children().prop("checked", true);
      $(this).parent().next().next().next().children().prop("checked", true);
      $(this)
        .parent()
        .next()
        .next()
        .next()
        .next()
        .children()
        .prop("checked", true);
    } else if ($(this).prop("checked") === false) {
      $(this).parent().next().children().prop("checked", false);
      $(this).parent().next().next().children().prop("checked", false);
      $(this).parent().next().next().next().children().prop("checked", false);
      $(this)
        .parent()
        .next()
        .next()
        .next()
        .next()
        .children()
        .prop("checked", false);
    }
  });
});

CKEDITOR.replace("content_addNews");
CKEDITOR.replace("content_editNews");
