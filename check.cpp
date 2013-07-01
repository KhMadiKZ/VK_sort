#include <algorithm>
#include <string>
#include <iostream>
#include <fstream>
#include <queue>
#include <ctime>

using namespace std;

struct story {
    string link, txt;
    int  likes, shares;
    string id, date;
    bool operator < (const story &x) const {
        return likes > x.likes;
    }
}all[200000];
string s;

string toStr (int x) {
    string s = "";
    while (x) s += char(x%10+'0'), x /= 10;
    reverse(s.begin(), s.end());
    return s;
}

void timeNow() {
    time_t t = time(NULL);
    struct tm *tm = localtime(&t);
    char date[20];
    strftime(date, sizeof(date), "%Y-%m-%d", tm);      
    printf("%s", date);
}

void timeGet() {
    time_t t = time(NULL);
    struct tm *tm = localtime(&t);
    char date[20];
    strftime(date, sizeof(date), "%Y-%m-%d", tm);      
    printf("%s\n", date);
}


int main(int argc, char** argv)
{
    freopen ("data", "r", stdin);
    freopen ("index.html", "w", stdout);
    
    string tmp;
    int ok = 0;
    int sz;
    cin >> sz;
    getline(cin, tmp);
    for (int i = 0; i < sz; i++) {
        int x, y;
        cin >> x >> y;
        getline(cin, tmp);
        all[i].likes = x, all[i].shares = y;
        getline(cin, all[i].date);
        cerr << all[i].date << endl;
        getline(cin, all[i].txt);
        getline(cin, all[i].id);
        cerr << all[i].id << endl;
        all[i].link = "http://vk.com/ktlstories?w=wall-55298594_" + all[i].id;
        cerr << all[i].link << endl;
    }
    
    sort(all,all+sz);
   
    cout << "<html><head>\n<title>KTL Stories Rating</title>\n</head>\n";

    cout << "<body>\n";
    cout << "<center><h2><a href=\"http://vk.com/ktlstories\">KTL Stories</a> Rating</h2></center>\n";
    cout << "<center><h2>Last Update: "; timeNow(); cout << "</h2></center>\n";
    for (int i = 0; i < sz; i++) {
        cout << i+1 << "<br/>\n";
        cout << "Date : " << all[i].date << "<br/>\n";
        cout << "Shares: " << all[i].shares << " Likes: " << all[i].likes << "<br/>\n";
        cout << "<a href=\"" << all[i].link << "\">-Link-</a><br/>\n";
        cout << all[i].txt << "<br/>\n";
        cout << "<br/>\n";
    }
    cout << "\n</body>\n</html>";


    return 0;
}       
