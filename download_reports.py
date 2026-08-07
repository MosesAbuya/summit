import urllib.request
import os

reports = [
    {
        'title': '2019 Global Pro Bono Summit (New York) Report',
        'url': 'https://globalprobono.org/wp-content/uploads/2019/12/GPBS_Upshot_2019_final.pdf',
        'filename': 'GPBS_Upshot_2019_final.pdf'
    },
    {
        'title': '2017 Global Pro Bono Summit (Lisbon) Report',
        'url': 'https://globalprobono.org/wp-content/uploads/2018/02/Global_ProBono_Summit_2017_overview.pdf',
        'filename': 'Global_ProBono_Summit_2017_overview.pdf'
    },
    {
        'title': '2016 Global Pro Bono Summit (Singapore) Report',
        'url': 'https://globalprobono.org/wp-content/uploads/2018/02/global-pro-bono-summit-2016-recap.pdf',
        'filename': 'global-pro-bono-summit-2016-recap.pdf'
    },
    {
        'title': '2015 Global Pro Bono Summit (Berlin) Report',
        'url': 'https://globalprobono.org/wp-content/uploads/2018/02/global-pro-bono-summit-2015-summary.pdf',
        'filename': 'global-pro-bono-summit-2015-summary.pdf'
    },
    {
        'title': '2014 Global Pro Bono Summit (San Francisco) Report',
        'url': 'https://globalprobono.org/wp-content/uploads/2018/02/global-pro-bono-summit-2014-summary.pdf',
        'filename': 'global-pro-bono-summit-2014-summary.pdf'
    },
    {
        'title': '2013 Global Pro Bono Summit (New York) Report',
        'url': 'https://globalprobono.org/wp-content/uploads/2018/02/global-pro-bono-summit-2013-summary.pdf',
        'filename': 'global-pro-bono-summit-2013-summary.pdf'
    }
]

os.makedirs('assets/resources', exist_ok=True)

for r in reports:
    dest = os.path.join('assets/resources', r['filename'])
    if not os.path.exists(dest):
        try:
            print(f"Downloading {r['filename']}...")
            req = urllib.request.Request(r['url'], headers={'User-Agent': 'Mozilla/5.0'})
            with urllib.request.urlopen(req) as response, open(dest, 'wb') as out_file:
                out_file.write(response.read())
            print("Done")
        except Exception as e:
            print(f"Failed to download {r['filename']}: {e}")
    else:
        print(f"File {r['filename']} already exists.")
