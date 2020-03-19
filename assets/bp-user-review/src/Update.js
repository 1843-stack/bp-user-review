const { createElement, render, useState,useEffect,Fragment} = wp.element;
//import "./Fetch.css";



const UpdateUserReview = (props) =>{


	const [isLoading, setIsLoading]= useState(true);
	const [args,setArgs] = useState({
		reviewer_id:window.update_user_review_table.reviewer_id,
		reviewee_id:window.update_user_review_table.reviewee_id,
		title:'',
		stars:0,
		review:''
	});
	const [reviews, setReviews] = useState([]);
	const [formId, setFormId] = useState('');

    useEffect(()=>{	 	
		if (isLoading) {
			setIsLoading(false);
		 	// console.log(args);
		 	fetch(`${window.update_user_review_table.api}/fetch_user_review/`,{
	     	method:'POST',
		 	 	body:JSON.stringify({user_id:window.update_user_review_table.reviewer_id})
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
	
    useEffect(()=>{

    },[formId]);

	return (
            
		//console.log('abc');
		<div>
		 <h1> Here form for update review</h1>
		 {
			Object.keys(reviews).map((key, val)=>{
				return (
					<div>
						<span>{reviews[key].msg}</span>

						<span><input type="submit" className={key} onClick={()=>setFormId({key})} value={window.update_user_review_table.update_text} /></span>
					</div>
					/*{
						formId==key?
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
							
							<input type="submit" value="Submit" name="bp_ur_submit_review" onClick="" />
						</div>
						:"";
					}*/
				)
			})
		}
		</div>
		  
             		
	   		



		
       

	);



}


document.addEventListener("comment_meta_component",(e)=>{
		setTimeout(()=>{
			render( <UpdateUserReview /> ,
			   document.querySelector('.update_user_review_table')
			);
		},200);
},false);


