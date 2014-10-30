function doMenu()
{
    $.ajax({
                    url: 'programs_ajax.php',
                    cache: false,
                    data: {'request': 'readPrograms'},
                    dataType: 'json',
                    success: function(data)
                    {
                        var dataArray = data.resultData;
                        var thisCat =0;
                        var nextCat =0;
                        
                        if (location.pathname.substring(1) == "project5/pages/homePage.php")
                        {
                            var outputStr = "<ul class='nav'><br>";
                        }
                        else
                        {
                            var outputStr = "<ul class='nav'><br><li><a href='homePage.php'>Go Home</a></li><br><br>";
                        }
                        for (var i = 0; i < dataArray.length; i++)
                        {
                            //alert(dataArray[i].categoryId);
                            nextCat = Number(dataArray[i].categoryId);
                            if (thisCat != nextCat)
                            {
                              if (thisCat>0)
                                    outputStr = outputStr + "</ul></li>";
                              outputStr = outputStr + "<li><a href='#'>" + dataArray[i].categoryDesc + "</a><ul>"; 
                              thisCat = nextCat;
                            }
                            
                            outputStr = outputStr + "<li><a href='" + dataArray[i].programName + "'>";
                            outputStr = outputStr + dataArray[i].programDesc + "</a></li>";
                            
                        }
                        outputStr = outputStr + "</ul></li>";
                        outputStr = outputStr + "<br><br><li><a href='loginPage.php'>Log Out</a></li></ul>";
                        //alert(outputStr);
                        $('#menuBar').html(outputStr);
                        $('.nav').navgoco();
                    }
                });    
}