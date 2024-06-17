<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

//On inclut les fichiers nécessaires
require_once __DIR__ . "/libraries/path.php";
require_once __DIR__ . "/libraries/method.php";
require_once __DIR__ . "/libraries/response.php";
require_once __DIR__ . "/libraries/parameters.php";


//pour la route /login 
if (isPath("login")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/login.php";
        die();
    }
}

//route pour le login assistance, sans captcha
if (isPath("loginAssistance")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/loginAssistance.php";
        die();
    }
}

if (isPath("register")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/users/post.php";
        die();
    }
}
##############################USERS##############################

if (isPath("users/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/users/getById.php";
        die();
    }
}


if (isPath("users")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/users/get.php";
        die();
    }
}

if (isPath("usersbytoken/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/users/getByToken.php";
        die();
    }
}

//Photo de profil

if (isPath("getPpById/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/users/getPpById.php";
        die();
    }
}



##############################ADS##############################

if (isPath("housingDisponibility/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/ads/getHousingDisponibilityById.php";
        die();
    }
}

if(isPath("housing/:id")){
    if(isGetMethod()){
        require_once __DIR__ . "/routes/ads/getHousingById.php";
        die();
    }

}


if (isPath("performanceDisponibility/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/ads/getPerformanceDisponibilityById.php";
        die();
    }
}


if (isPath("addAdsDisponibility")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/ads/addAdsDisponibility.php";
        die();
    }
}

if (isPath("housingAdsImages/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/ads/getHousingAdsImagesById.php";
        die();
    }
}

if (isPath("performanceAdsImages/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/ads/getPerformancesAdsImagesById.php";
        die();
    }
}

if (isPath("getHousingAdsInfo/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/ads/getHousingAdsInfoById.php";
        die();
    }
}

if (isPath("getPerformanceAdsInfo/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/ads/getPerformanceAdsInfoById.php";
        die();
    }
}

if (isPath("getAllCatalogByChoice/:type")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/ads/getAllCatalogByChoice.php";
        die();
    }
}

if (isPath("getHousingCatalogByType/:type")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/ads/getHousingCatalogByChoice.php";
        die();
    }
}

if (isPath("getPerformanceCatalogByType/:type")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/ads/getPerformanceCatalogByType.php";
        die();
    }
}


if (isPath("getHousingCatalogBySearch")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/ads/getHousingCatalogBySearch.php";
        die();
    }
}

if (isPath("getPerformanceCatalogBySearch")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/ads/getPerformanceCatalogBySearch.php";
        die();
    }
}

//Faire la moyenne des notes
if (isPath("getAverageRate")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/ads/getAverageRate.php";
        die();
    }
}
//Récupérer les commentaires
if (isPath("getComments")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/ads/getComments.php";
        die();
    }
}
#############################Booking##############################

if (isPath("addBooking")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/ads/booking/addBooking.php";
        die();
    }
}

if (isPath("getBookingByTravelerId/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/ads/booking/getBookingByTravelerId.php";
        die();
    }
}

if (isPath("addReview")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/ads/booking/addReview.php";
        die();
    }
}

if(isPath("getAllBookingByOwnerId/:id")){
    if(isGetMethod()){
        require_once __DIR__ . "/routes/ads/booking/getAllBookingByOwnerId.php";
        die();
    }

}

if(isPath("booking/:id")){
    if(isGetMethod()){
        require_once __DIR__ . "/routes/ads/booking/getBookingById.php";
        die();
    }
}
##############################Likes##############################
if (isPath("getLikes/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/likes/getLikes.php";
        die();
    }
}

if (isPath("addLike")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/likes/addLike.php";
        die();
    }
}

if (isPath("removeLike")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/likes/removeLike.php";
        die();
    }
}

if (isPath("isLiked")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/likes/isLiked.php";
        die();
    }
}

##############################Tickets##############################
if (isPath("getTicketsByUserId/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/support/tickets/getTicketsByUserId.php";
        die();
    }
}

if (isPath("getTicketById/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/support/tickets/getTicketById.php";
        die();
    }
}

if (isPath("addTicket")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/support/tickets/addTicket.php";
        die();
    }
}

if (isPath("addTicketAnswer")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/support/tickets/addTicketAnswer.php";
        die();
    }
}

if (isPath("changeStatusTicket")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/support/tickets/changeStatusTicket.php";
        die();
    }
}

if (isPath("getTicketAnswers/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/support/tickets/getTicketAnswers.php";
        die();
    }
}

if (isPath("getTicketsByStatus/:status")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/support/tickets/getTicketsByStatus.php";
        die();
    }
}

if(isPath("getAssignedTicketsByUserId/:id")){
    if(isGetMethod()){
        require_once __DIR__ . "/routes/support/tickets/getAssignedTicketsByUserId.php";
        die();
    }
}

##############################PrivateMessages##############################

if (isPath("private-message/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/private-messages/getPrivateMessage.php";
        die();
    }
}
if (isPath("private-message")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/private-messages/addPrivateMessage.php";
        die();
    }
}


if (isPath("addConversation")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/private-messages/addConversation.php";
        die();
    }
}

if (isPath("addAHouse")){
    if (isPostMethod()){
        require_once __DIR__ . "/routes/ads/addAHouse.php";
        die();
    }
}


######################Password##############################
if (isPath("resetPasswordVerifyUser")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/password/resetPasswordVerifyUser.php";
        die();
    }
}

if (isPath("resetPassword")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/password/resetPassword.php";
        die();
    }
}

if(isPath("updateUser")){
    if(isPostMethod()){
        require_once __DIR__ . "/routes/users/updateUser.php";
        die();
    }
}

if(isPath("updatePassword")){
    if(isPostMethod()){
        require_once __DIR__ . "/routes/users/updatePassword.php";
        die();
    }
}



if(isPath("test")){
    if(isPostMethod()){
        require_once __DIR__ . "/routes/test.php";
        die();
    }
}