(function(e){e.fn.equalHs=function(){var t=0,n=e(this);n.children(".ggclItemCntr").each(function(){var n=e(this).innerHeight();if(n>t){t=n}});n.children(".ggclItemCntr").css("min-height",t+1)}})(jQuery)