import java.net.*;

import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Scanner;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.*;
import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.HttpVersion;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.ContentBody;
import org.apache.http.entity.mime.content.FileBody;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.params.CoreProtocolPNames;
import org.apache.http.util.EntityUtils;
import java.security.*;
 
public class Client extends Thread implements ActionListener{
	 private String threadName;
	 private Application application;
	 
	// ThreadLocal<Integer> tlocal = new ThreadLocal<Integer>();
	 public Client(String threadName, Application appli) {
	        this.threadName = threadName;
	        this.application = appli;
	        this.start();
	    }
	 public void actionPerformed(ActionEvent e) {
	      //  this.application.afficher(this.application.contenuChampA() + this.application.contenuChampB());
	        try
            {
	
	String str = this.application.contenuChampA();
	

	String str2 = String.valueOf(this.application.contenuChampB());
	System.out.println("Email:"+str+"Password:"+str2);

	// int i = Integer.parseInt(str);
	// tlocal.set(i);
	MessageDigest md;
	 md= MessageDigest.getInstance("SHA-512");
	md.update(str2.getBytes());
            byte[] mb = md.digest();
            String out = "";
            for (int i = 0; i < mb.length; i++) {
                byte temp = mb[i];
                String s = Integer.toHexString(new Byte(temp));
                while (s.length() < 2) {
                    s = "0" + s;
                }
                s = s.substring(s.length() - 2);
                out += s;
            }
           // System.out.println(out.length());
          //  System.out.println("CRYPTO: " + out);
	
	// System.out.println(tlocal.get());
        while(true) {
            
            URL LemZoun = new URL("http://localhost/LemZoun/Synchronisation/test2.php");
            HttpURLConnection yc = (HttpURLConnection) LemZoun.openConnection();
    		yc .setDoOutput(true); 
    		yc.setRequestMethod("POST");
    		
    		OutputStreamWriter writer = new OutputStreamWriter(yc.getOutputStream());
    		 writer.write("Email="+str+"&Password="+out);
    		 writer.flush();
    		 
    		
            BufferedReader in = new BufferedReader(new InputStreamReader(yc.getInputStream()));
            String inputLine;
            String date_upload;
            String date_modification;
            while ((inputLine = in.readLine()) != null) 
            {	
            	//System.out.println(inputLine);
            	if(inputLine.equals("error error"))
            	{
            		
            	}
            	else
            	{
            		 this.application.fermer();
            String Tab[]=inputLine.split(" ");
            inputLine=Tab[0];
            date_upload=Tab[2];   	
            date_upload=Tab[1]+" "+Tab[2];
           //System.out.println(Tab[1]);
           //System.out.println(Tab[2]);
	               // télécharger les fichiers du serveur en local
	                String url2="http://localhost/lemzoun/environnement/donnee/"+inputLine;
	                String test=inputLine.substring(10,inputLine.length());
	                String local="C:/LemZoun/"+test;
	                File repertoire = new File("C:/LemZoun");
	                if(!repertoire.exists())
	                {
	                	File dir = new File ("C:/LemZoun");
	                	dir.mkdirs();
	                	//dos("cmd.exe /k copy \\\\C:\\install\\ico\\Desktop.txt C:\\mon_dossier\\Desktop.ini & exit");
	                	//dos("cmd.exe /k attrib +S C:\\mon_dossier & exit");
	                }
	                File f= new File(local);
	                if(f.exists()==true)
	                {
	                	SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
	                	
	                	 Date d = new Date(f.lastModified());
	                	 date_modification=sdf.format(d);
	                	 Date d2 = sdf.parse(date_modification);
	                	// System.out.println(f.getName()+"en local"+d2); 
               	 
	                	 Date d3 = sdf.parse(date_upload);
	                	// System.out.println(f.getName()+" en serveur "+d3); 
               	 
	                	 if(d2.before(d3))
	                	 {
	                		  f.delete();
	                		  InputStream in2 = new URL(url2).openStream();
				                OutputStream out2 = new BufferedOutputStream(new FileOutputStream(local));
				                byte[] buf = new byte[1024];
				                int n;
				                while ((n=in2.read(buf,0,buf.length))>0) out2.write(buf,0,n);
				                out2.close();
				                in2.close();
	                	 }
	                	 else if (d3.before(d2))
	                	 {
	                		 HttpClient httpclient = new DefaultHttpClient();
		      	                httpclient.getParams().setParameter(CoreProtocolPNames.PROTOCOL_VERSION, HttpVersion.HTTP_1_1);
		      	                
		      	                HttpPost httppost = new HttpPost("http://localhost/LemZoun/Synchronisation/test4.php?id="+str);
		      	               
		      	              
		      	               // writer.write("nom_file="+files_a[i].getName()+"&date_modification="+file.lastModified());
		      	                MultipartEntity mpEntity = new MultipartEntity();
		      	                ContentBody contentFile = new FileBody(f);
		      	                mpEntity.addPart("userfile", contentFile);
		      	                httppost.setEntity(mpEntity);
		      	                System.out.println("executing request " + httppost.getRequestLine());
		      	                HttpResponse response = httpclient.execute(httppost);
		      	                HttpEntity resEntity = response.getEntity();
		      	         
		      	                if(!(response.getStatusLine().toString()).equals("HTTP/1.1 200 OK")){
		      	                    // Successfully Uploaded
		      	                }
		      	                else{
		      	                    // Did not upload. Add your logic here. Maybe you want to retry.
		      	                }
		      	                System.out.println(response.getStatusLine());
		      	                if (resEntity != null) {
		      	                    System.out.println(EntityUtils.toString(resEntity));
		      	                }
		      	                if (resEntity != null) {
		      	                    resEntity.consumeContent();
		      	                }
		      	                
		          				httpclient.getConnectionManager().shutdown();
	                	 }
	                	 else
	                	 {
	                		 System.out.println(f.getName()+"pas de modification"); 
	                	 }
	                }
	                else
	                {
	                InputStream in2 = new URL(url2).openStream();
	                OutputStream out2 = new BufferedOutputStream(new FileOutputStream(local));
	                byte[] buf = new byte[1024];
	                int n;
	                while ((n=in2.read(buf,0,buf.length))>0) out2.write(buf,0,n);
	                out2.close();
	                in2.close();
	                }
	              }
            	}
                in.close();
           
            HttpClient httpclient = new DefaultHttpClient();
            httpclient.getParams().setParameter(CoreProtocolPNames.PROTOCOL_VERSION, HttpVersion.HTTP_1_1);
            
            HttpPost httppost = new HttpPost("http://localhost/LemZoun/Synchronisation/test3.php?id="+str);
            File repertoire = new File("C:/LemZoun");
			File[] files_a=repertoire.listFiles();
			for(int i=0;i<files_a.length;i++)
			{
            File file = new File(files_a[i].getPath());
           // writer.write("nom_file="+files_a[i].getName()+"&date_modification="+file.lastModified());
            MultipartEntity mpEntity = new MultipartEntity();
            ContentBody contentFile = new FileBody(file);
            mpEntity.addPart("userfile", contentFile);
            httppost.setEntity(mpEntity);
            System.out.println("executing request " + httppost.getRequestLine());
            HttpResponse response = httpclient.execute(httppost);
            HttpEntity resEntity = response.getEntity();
     
            if(!(response.getStatusLine().toString()).equals("HTTP/1.1 200 OK")){
                // Successfully Uploaded
            }
            else{
                // Did not upload. Add your logic here. Maybe you want to retry.
            }
            System.out.println(response.getStatusLine());
            if (resEntity != null) {
                System.out.println(EntityUtils.toString(resEntity));
            }
            if (resEntity != null) {
                resEntity.consumeContent();
            }
            
			}httpclient.getConnectionManager().shutdown();
         /*    
            URL oracle2 = new URL("http://localhost/LemZoun/Synchronisation/test3.php");
            HttpURLConnection yc2 = (HttpURLConnection) oracle2.openConnection();
    		yc2 .setDoOutput(true); 
    		yc2.setRequestMethod("POST");
         télécharger les fichiers  local sur le serveur
            File repertoire = new File("C:/Users/Mariem/Desktop/E-commerce");
			File[] files_a=repertoire.listFiles();
			OutputStreamWriter writer_serveur = new OutputStreamWriter(
    	            yc2.getOutputStream());
			for(int i=0;i<files_a.length;i++)
			{
				try{
					File importFile = new File(files_a[i].getPath());
					
					URL url = new URL("http://localhost/LemZoun/Synchronisation/test3.php");
					URLConnection uc = url.openConnection();
					HttpURLConnection connection = (HttpURLConnection) url.openConnection();
					connection.setRequestMethod("POST");
					connection.setDoOutput(true);
					connection.connect();

					FileInputStream is = new FileInputStream(importFile);
					OutputStream os = connection.getOutputStream();
					ByteArrayOutputStream out = new ByteArrayOutputStream();
					
					
					
					byte[] buffer = new byte[4096682];
					int bytes_read;
					while((bytes_read = is.read(buffer)) != -1) {
					   os.write(buffer, 0, bytes_read);
					   out.write(buffer, 0, bytes_read);
					   //System.out.println(out);
					 //  Path path = Paths.get(files_a[i].getPath());
						//byte[] data = Files.readAllBytes(path);
					   writer_serveur.write("nom_file="+files_a[i].getName()+"&contenu="+out);
				
			    					} }	
			    				catch (Exception e){
			    					System.out.println(e.toString());
			    				}
			    				
		  						
		    				}
			    			writer_serveur.close(); 
			    			 BufferedReader in_serveur = new BufferedReader(new InputStreamReader(yc2.getInputStream()));
				                String inputLine_serveur;
				                while ((inputLine_serveur = in_serveur.readLine()) != null) 
				                {	
				                    System.out.println(inputLine_serveur);
				                 }
				                in_serveur.close();	
					
			
			
    		 /*
                OutputStreamWriter writer_serveur = new OutputStreamWriter(
        	            yc.getOutputStream());
                File repertoire = new File("C:/Users/Mariem/Desktop/E-commerce");
    			File[] files_a=repertoire.listFiles();
    			
    			
    				for(int i=0;i<files_a.length;i++)
    				{
    					
    					  writer_serveur.write("file="+files_a[i].getPath());
    		        	  writer_serveur.flush(); 
    						
    				}
        	
    				writer_serveur.close(); 
        		
                */
    		 
    		 
    		 
    		 
    		 
    		 
    		 
    		 
    		 
    		 
            
			writer.close();
			System.out.println("fin");
			// this.application.afficher(this.application.contenuChampA() + this.application.contenuChampB());
            	Thread.sleep(100000);
            	 
            }   
     
            
}
            catch(Exception e1){
            e1.printStackTrace();	
            
            }
	    }
	
	  public void run() {
	    
	       
	    }

   
}