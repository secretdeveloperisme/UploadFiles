$(function(){
  $("#fileToUpload").change(function(){
    console.log([this]);
    [...$(this)[0].files].forEach((value)=>{
      let divFile = document.createElement("li")
      divFile.className = "fileItem"
      divFile.innerHTML = `<span class="file-name">${value.name}</span>
                          <span class = "file-type">${value.type}</span>
                          <span class="file-size">${(value.size)/1000}KB</span>`
      $("#listFile").append(divFile)
    })
  })
  $("#showDir").click((event)=>{
    window.location = "showFiles.php"
  })
  $.ajax({
    url : "listFolder.php",
    type : "GET",
    dataType : "json",
    success : (response)=>{
      response = response
      .map((value,index)=>{
        return `<option value="${value}/">${value}</option>`
      })
      $("#directory").html(response.join("\n"))
    }

  })
})
