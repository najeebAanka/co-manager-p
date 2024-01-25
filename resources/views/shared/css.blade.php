  <style type="text/css">

  @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;700&display=swap');

  
      
      
      
      .card-header:first-child{
          direction: {{$direction}};
      text-align: center;;
          color: #2196F3;
    font-size: 1.5rem;
      }
      
        body{
            margin: 0;
            font-size: .9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: {{$alignment}};
            background-color: #f5f8fa;
            direction: {{$direction}};
     
            font-family: 'Noto Sans Arabic', sans-serif;
            font-size: 16.3px;
            
        }
        .navbar-laravel
        {
            box-shadow: 0 2px 4px rgba(0,0,0,.04);
        }
        .navbar-brand , .nav-link, .my-form, .login-form
        {
              font-family: 'Noto Sans Arabic', sans-serif;
        }
        .my-form
        {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
        .my-form .row
        {
            margin-left: 0;
            margin-right: 0;
        }
        .login-form
        {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
        .login-form .row
        {
            margin-left: 0;
            margin-right: 0;
        }
        
        /* .sq-master {
    text-align: center;
    padding: 1rem;
    background-color: #2196F3;
    color: #fff;
    font-size: 1.5rem;
    margin: 1rem;
} */

.sq-master {
    background-color: #f2f2f2;
    /* padding: 20px; */
    padding: 50px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-bottom: 10px;
}


/* .sq-master:hover {
 cursor: pointer;
    background-color: #66ccff;
  
} */

.sq-master:hover {
    cursor: pointer;
    background-color: #e0e0e0;
}

.department-btn i {
    font-size: 36px;
    color: #3498db;
    margin-bottom: 10px;
}

.task-row {
 border-bottom: solid 1px #ccc;
}
.task-row .row  {
       padding-top: 20px;
}

 div#tasks-container {

}



.task-row-select {
    border: none;
    max-width: 190px;
    /* border-radius: 7px; */
    text-align: center;
    background-color: #f2f2f2;
     float: {{$alignment == 'right' ? 'left' : 'right'}};
    margin: 0 7px;
    padding: 6px;
    margin-bottom: 20px;
}


.task-row-submit {
   
     float: {{$alignment == 'right' ? 'left' : 'right'}};
     margin: 0 7px;
    padding: 6px;
    margin-bottom: 20px;
    width: 150px;
}


.align-end{
    text-align: {{$alignment}};
}

.user-dept-name{
    /* color: #4a67b9; 
    font-weight: 500; */
    color: #888;
}

.user-name{
    /* font-weight: 500; */
    /* font-size: 18px; */
        font-weight: bold;
        color: #51718f;
}



.custom-table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
    }

    .custom-table th,
    .custom-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }



    /* width */
    ::-webkit-scrollbar {
        width: 0px;
          transition: all 0.5s ease-in-out;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #e9e9e9;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #fff;
        border-radius: 5px;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #ccc;
      
        

    }
.status-in-progress-i {
    background-color: #ff9900;
    color: #fff;
    padding: 4px;
    font-size: 11px;
        border-radius: 50%;
}
.status-to-do-i {
    background-color: #999999;
    color: #fff;
    padding: 4px;
    font-size: 11px;
        border-radius: 50%;
}
.status-done-i {
    background-color: #34a853;
    color: #fff;
    padding: 4px;
    font-size: 11px;
        border-radius: 50%;
}
    .task-text:hover{
       
        cursor: pointer;
    }
/*    .task-text{
    font-weight: bold;
    }*/

    
    option[value=to-do] { 
    background-color: "#f2f2f2";
}
    option[value=in-progress] { 
    background-color: "#b6dfff" !important;
}
    option[value=done] { 
    background-color: "#c5ffc5";
}
  option  { 
    padding: 5px;
}
   [contenteditable] {
  outline: 0px solid transparent;
} 
.edit-task-title {
    background-color: #f6f6f6;
    padding: 6px;
    font-size: 13px;
    margin-right: 5px;
    margin-left: 5px;
    border-radius: 3px;
    color: #666;
}
.task-status-done{
    text-decoration: line-through;
    font-weight: normal;
}

.spannable-link:hover{
 cursor: pointer;
 text-decoration: underline
}

body{
    background: url('{{url("assets/img/pexels-stephan-seeber-1054218.jpg")}}');
    background-attachment: fixed;
    background-position: center;
    background-size: 100% 100%;
}
.btn ,.form-control ,.card ,.card-body ,.card-header{
    border-radius: 0px;
    
}
.form-control{
        min-height:  3rem;
}

.card-header {
  background-color: white;
    font-weight: bold;
}

.f-cnter{
    font-size: 2rem;
   margin-bottom: 1rem
}
.card{
    background-color: #ffffffba;;
    border: none;
    backdrop-filter: blur(12px);
}
/* i.bn8975 {
    font-size: 13px;
} */

i.bn8975 {
    font-size: 16px;
   color: #988f8f;
}

.user-card {
        background-color: #ffffff;
        /* border-radius: 10px; */
        border-radius: 5px;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        transition: transform 0.2s;
    }

    .user-card:hover {
        transform: translateY(-5px);
    }


    .profile-icon {
        /* background-color: #ededed; */
        width: 100px;
        height: 100px;
        margin-bottom: 10px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto 10px;
    }

    .profile-icon i {
        font-size: 50px;
        color: #ccc;
    }




.navbar-light .navbar-nav .nav-link {
    color: rgb(0 0 0);
  font-size: 16.3px;
}


span.span-prog {
    background-color: #14ae14;
    font-size: 9px;
    color: #fff;
    border-radius: 10px;
    padding: 2px 7px;
    /* padding-left: 5px; */
    font-weight: bold;
    margin: 0px;
    font-family: system-ui;
}

span.span-file {
    background-color: #869b86;
    font-size: 12px;
    color: #fff;
    border-radius: 10px;
    padding: 2px 7px;
    /* padding-left: 5px; */
    font-weight: bold;
    margin: 0px;
    font-family: system-ui;
}

span.red-span {
    background-color: #e4022f;
}
.task-text{
    DISPLAY: FLEX;
    ALIGN-ITEMS: CENTER;
    gap: 1rem;
}


/* ---------------------------check box style */

/* Custom checkbox style */
.custom-checkbox {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    /* width: 20px;
    height: 20px; */
    width: 25px;
    height: 25px;
    background-color: #eee;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
    cursor: pointer;
    position: relative;
}

/* Custom checkbox style when checked */
.custom-checkbox:checked {
    background-color: #2196F3;
    border-color: #2196F3;
}

/* Pseudo-element for the checkmark */
.custom-checkbox:checked::before {
    content: "\2713";
    font-size: 14px;
    color: white;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

/* Custom checkbox style when hovered */
.custom-checkbox:hover {
    /* background-color: #ccc; */
    background-color: #8398ef;
}

/* Custom checkbox style when focused */
.custom-checkbox:focus {
    box-shadow: 0 0 3px 2px rgba(33, 150, 243, 0.6);
}

/* -------------- End checkbox style */

    </style>