package com.example.cabapp.utils;

public class DataManipulationUtils {

	public String HashCredentials(String text) {
		return null;
	}

	public String decodeJson(String subject) {
		return subject;
	}
	
	public String encodeJson(String subject) {
		return subject;
	}
	
	public String[] readDetailsFromSMS(String smsText) {
		String [] smsDetails= new String []{"","","","",""};   //#45|1|[OrderID]     1-firstwarning 2-cancelwarning
		String [] textElements=smsText.split("\\s");
		for(String s:textElements){
			if(s.trim().startsWith("#")){
				smsDetails[4] = s;
				smsDetails[0] = s.substring(3,4);
				smsDetails[1] = s.substring(4); 
				smsDetails[3] = s.substring(1,3);
			}else{
				smsDetails[2] += s;
			}
		}
		return smsDetails;
	}
}
