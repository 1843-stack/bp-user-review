const { createElement, render, useState,useEffect,Fragment} = wp.element;

const GetUserReview = (props) =>{



	/*const [args,setArgs] = useState({
		reviewer_id:window.bp_user_review.reviewer_id,
		reviewee_id:window.bp_user_review.reviewee_id,
		title:'',
		stars:0,
		review:''
	});

      
	//const [isSubmitted,setSubmitState] = useState(false);
	//const submitButton2 = () =>{

	 /*useEffect(()=>{
	 	//console.log('inside another component');
	 	
	 	console.log(args);
	 	fetch(`${window.bp_user_review.api}/fetch_user_review/`,{
     	method:'POST',
	 	 	body:JSON.stringify({user_id:window.bp_user_review.reviewer_id})
             }).then((res)=>res.json())
	 	.then((rreturn)=>{
	 	 	if(rreturn.status){
	 	 		console.log('return: ',rreturn);
	 	 		//setArgs({...args,...return.comment});
	 		}
	 	 });
	 	
	
	});*/
	 
	 	//return (<h1 className="me_block">sdfkhssdkjhfjsdkjfhkdf</h1>)
	 	//useEffect(()=>{
	 	////console.log('inside another component');
	 	
	
	//});

return (

		<h1>GetUserReview</h1>
		

	)





}


document.addEventListener("comment_meta_component",(e)=>{
		setTimeout(()=>{
			render( <GetUserReview /> ,
			   document.querySelector('.get_user_review_table')
			);
		},200);
},false);


