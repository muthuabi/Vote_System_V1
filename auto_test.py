import pyautogui as py
import subprocess as sp
from time import sleep
py.moveTo(400,735)
py.click()
sleep(2)
py.hotkey('ctrl','l')
sleep(1)
py.hotkey('ctrl','a')
sleep(1)
py.typewrite('http://localhost/Vote_System/user/cast_vote.php?shift=U2hpZnQtSQ==&vote_gender=TQ==')
sleep(2)
py.press('enter')
sleep(2)
py.moveTo(500,650)
for i in range(1,250):
    py.click()
    sleep(1)
    py.click()
    sleep(1)
    py.click()
    sleep(7)
    # if i%3==0:
    #     sleep(10)
    # sleep(1)
  
# btn_location=list(py.locateCenterOnScreen('vote_btn.png',confidence=0.5))
# print(btn_location)
# py.moveTo(btn_location[0],btn_location[1])
