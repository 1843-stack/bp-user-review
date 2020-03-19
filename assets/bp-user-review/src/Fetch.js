const { createElement, render, useState,useEffect,Fragment} = wp.element;
//import "./Fetch.css";



const GetUserReview = (props) =>{


	const [isLoading, setIsLoading]= useState(true);
	const [args,setArgs] = useState({
		reviewer_id:window.get_user_review_table.reviewer_id,
		reviewee_id:window.get_user_review_table.reviewee_id,
		title:'',
		stars:0,
		review:''
	});
	const [reviews, setReviews] = useState([]);

      
	//const [isSubmitted,setSubmitState] = useState(false);
	//const submitButton2 = () =>{

	useEffect(()=>{	 	
		if (isLoading) {
			setIsLoading(false);
		 	// console.log(args);
		 	fetch(`${window.get_user_review_table.api}/fetch_user_review/`,{
	     	method:'POST',
		 	 	body:JSON.stringify({user_id:window.get_user_review_table.reviewer_id})
	             }).then((res)=>res.json())
		 	.then((rreturn)=>{
		 	 	if(rreturn.status){
		 	 		console.log('return: ',rreturn.comment);
		 	 		//setArgs({...args,...rreturn.comment});
		 	 		setReviews(rreturn.comment);
		 	 		// props.content = rreturn.comment;
		 	 		//console.log(reviews);
		 	 	// 	var comment = rreturn.comment;
		 	 	// Object.keys(comment).map((key, value)=>{console.log(comment[key])});


		 	 			 	 	
		 		}
		 	 });
		 }
	});
return (
	<div>
	   		<table>
			<tr> 
				<th>Name:</th>
				<th>Message</th>
				<th>Rating</th>
				<th>Comment ID</th>
			</tr>
				{
					Object.keys(reviews).map((key, val)=>{
						return (
							<tr>
								<td>{reviews[key].title}</td>
								<td>{reviews[key].msg}</td>
								<td>{reviews[key].stars}</td>
								<td>{key}</td>
							</tr>
						)
					})
				}
		</table>
		</div>
	);





}


document.addEventListener("comment_meta_component",(e)=>{
		setTimeout(()=>{
			render( <GetUserReview /> ,
			   document.querySelector('.get_user_review_table')
			);
		},200);
},false);


