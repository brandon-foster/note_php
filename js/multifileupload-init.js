$(document).ready(function()
{
    // handler for select option change
    $('select[name=album-id]').change(function() {
        var albumId = $('select[name=album-id] option:selected').val();
        var theUrl = "./index.php?api=upload-photos&album-id=" + albumId;
        setUpFileUpload(theUrl);
    });
    
    // sets up the file uploading
    var setUpFileUpload = function(theUrl) {
        var settings = {
                url: theUrl,
                method: "POST",
                allowedTypes:"jpg,png,gif",
                fileName: "user-image",
                multiple: true,
                onSuccess:function(files,data,xhr)
                {
                    if (data.error) {
                        $('.welcome').after(data.error);
                        console.log(data);                
                    } else {
                        console.log(data);
                    }
                    $("#status").html("<font color='green'>Upload succeeded</font>");
                },
                afterUploadAll:function() {
                    console.log('all images uploaded');
                    //alert("all images uploaded!!");
                },
                onError: function(files,status,errMsg) {
                    console.log('error');
                    $("#status").html("<font color='red'>Upload failed</font>");
                }
            };
            $("#mulitplefileuploader").uploadFile(settings);
    };
});
