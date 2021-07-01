import java.io.File;
import java.io.IOException;
import org.apache.commons.io.FileUtils;
import org.apache.commons.io.LineIterator;
import org.apache.commons.lang.StringUtils;
import java.net.HttpURLConnection;
import java.net.URL;
import java.io.OutputStream;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import org.json.JSONObject;
import org.json.JSONException;

public class Main {

    public static void main(String[] args) {

        File file = new File("/storage/emulated/0/QQData/5_6235747856104293057.txt");
        LineIterator it = null;
		
        try {
            it = FileUtils.lineIterator(file, "UTF-8");
            //int i=5;
            while (it.hasNext()) {
            //while (i > 0) {
                String line = it.nextLine();
                if (!StringUtils.isBlank(line)) {                  
                    //System.out.println(line); 
                    String phone = StringUtils.split(line, "----")[0];
                    String qq = StringUtils.split(line, "----")[1];  
                    submitData(qq, phone);              
                }


            }
        } catch (IOException e) {
            e.printStackTrace();
        }  finally {
            LineIterator.closeQuietly(it);
        }  

    }


    public static void  submitData(String qq, String phone) {
        HttpURLConnection conn = null;
        String result = null;     
        try {
            URL url = new URL("http://ssdlearn.top/qq/InsertIntoApi.php");
            conn = (HttpURLConnection) url.openConnection();
            conn.setRequestMethod("POST");
            conn.setConnectTimeout(3000);
            conn.setDoOutput(true);
            conn.setDoInput(true);
            conn.setUseCaches(false);
            conn.connect();
            String params =String.format("qq=%s&phone=%s", qq, phone);
            OutputStream out = conn.getOutputStream();
            out.write(params.getBytes());
            out.flush();
            out.close();
            int code = conn.getResponseCode();
            if (code == HttpURLConnection.HTTP_OK) {
                StringBuffer buffer = new StringBuffer();
                BufferedReader br = new BufferedReader(new InputStreamReader(conn.getInputStream(), "utf-8"));
                String temp = null;
                while ((temp = br.readLine()) != null) {
                    buffer.append(temp);
                    buffer.append("\n");
                }
                result = buffer.toString().trim();
                try {
                    JSONObject jsonObject = new JSONObject(result);            
                    int dataCode = jsonObject.getInt("code");
                    String dataMsg = jsonObject.getString("msg");
                    if (dataCode == 0) {
                        JSONObject dataObject = jsonObject.getJSONObject("data");
                        String backQQ = dataObject.getString("qq");
                        String backPhone = dataObject.getString("phone");                                             
                        System.out.println(String.format("QQ:%s|手机号:%s-提交成功!", backQQ, backPhone));
                    } else {
                        System.out.println(dataMsg);
                    } 

                } catch (JSONException e) {
                    e.printStackTrace();
                }

            }          
        } catch (IOException e) {
            e.printStackTrace();
        } finally {
            if (result != null)
                result = null;
            if (conn != null) 
                conn.disconnect();
        }


    }


}
