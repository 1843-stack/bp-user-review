const { createElement, render, useState,useEffect,Fragment} = wp.element;
// const API_URL = (window.bp_user_review1)?window.bp_user_review.api:'http://localhost/wordpress1/wp-json/bpur/v1';


const UserReview = (props) =>{

	const [args,setArgs] = useState({
		reviewer_id:window.bp_user_review.reviewer_id,
		reviewee_id:window.bp_user_review.reviewee_id,
		title:'',
		stars:0,
		review:''
	});

      
	const [isSubmitted,setSubmitState] = useState(false);
	//const submitButton2 = () =>{

	/* useEffect(()=>{
	 	console.log(args);
	 	fetch(`${window.bp_user_review.api}/fetch_user_review/`,{
     	method:'POST',
	 	 	body:JSON.stringify({user_id:window.bp_user_review.reviewer_id})
             }).then((res)=>res.json())
	 	.then((rreturn)=>{
	 	 	if(rreturn.status){
	 	 		console.log('return: ',rreturn);
	 	 		setArgs({...args,...return.comment});
	 		}
	 	 });
	 	
	
	});*/
//	}

 
	const submitButton1 = () =>{
	console.log(args);
		fetch(`${window.bp_user_review.api}/set_user_review/`,{
	 		method:'POST',
	 		body:JSON.stringify(args)
	 	}).then((res)=>res.json())
	 	.then((rreturn)=>{
	 		if(rreturn.status){
	 			//console.log("data: ", rreturn.data);
	 			 setArgs(rreturn.args);
	 			 console.log(args);     //data recieved
	 			 setArgs({...args,stars:0})
	 			 //now we insert data into database
	 		}
	 		 //setIsSubmitted(false);
	 	});
	 	
	}




	return (

		//console.log('abc');
		<div class="bp_user_review">
			<div class="bp_ur_review_title">
				<input type="text" name="bp_ur_review_title" placeholder="Name" value={args.title} onChange={(e)=>{setArgs({...args,title:e.target.value})}} />
			</div>
			<div class="bp_ur_review_stars">
				<span className={args.stars >= 1 ?'dashicons dashicons-star-filled':'dashicons dashicons-star-empty'} onClick={()=>setArgs({...args,stars:1})}></span>
				<span className={args.stars >= 2 ?'dashicons dashicons-star-filled':'dashicons dashicons-star-empty'} onClick={()=>setArgs({...args,stars:2})}></span>
				<span className={args.stars >= 3 ?'dashicons dashicons-star-filled':'dashicons dashicons-star-empty'} onClick={()=>setArgs({...args,stars:3})}></span>
				<span className={args.stars >= 4 ?'dashicons dashicons-star-filled':'dashicons dashicons-star-empty'} onClick={()=>{setArgs({...args,stars:4})}}></span>
				<span className={args.stars >= 5 ?'dashicons dashicons-star-filled':'dashicons dashicons-star-empty'} onClick={()=>{setArgs({...args,stars:5})}}></span>
	    	</div>
			<div class="bp_ur_review_message">
				<textarea placeholder="Message" name="bp_ur_review_message" value={args.review} onChange={(e)=>{setArgs({...args,review:e.target.value})}}></textarea>
			</div>
			
			<input type="submit" value="Submit" name="bp_ur_submit_review" onClick={()=>submitButton1()} />



		</div>
       

	)



}

window.addEventListener('DOMContentLoaded',()=>{
	let user = document.querySelector('.bp_user_review').getAttribute('data-user');
	let reviewed = document.querySelector('.bp_user_review').getAttribute('data-reviewed');
	
	render(<UserReview user={user} reviewed={reviewed} />,
		 document.querySelector('.bp_user_review')
	);
},false);
